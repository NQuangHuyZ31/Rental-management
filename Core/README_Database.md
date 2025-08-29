# Database Core - Query Builder & Logging System

Database Core cung cấp một hệ thống query builder mạnh mẽ với khả năng ghi log tự động vào database.

## 🚀 Tính năng chính

-   **Query Builder**: Xây dựng câu truy vấn SQL một cách linh hoạt
-   **Automatic Logging**: Tự động ghi log tất cả queries vào database
-   **Transaction Support**: Hỗ trợ transactions với rollback/commit
-   **Security**: Sử dụng PDO prepared statements để tránh SQL injection
-   **Performance**: Tối ưu hóa với connection pooling và query caching

## 📋 Cài đặt

### 1. Cấu hình Database

Đảm bảo các hằng số sau được định nghĩa trong `Config/config.php`:

```php
define('DB_HOST', 'localhost');
define('DB_NAME', 'your_database');
define('DB_USER', 'your_username');
define('DB_PASS', 'your_password');
```

### 2. Sử dụng trong Controller

```php
<?php

namespace App\Controllers;

use Core\Database;

class UserController extends Controller
{
    private $db;

    public function __construct()
    {
        parent::__construct();
        $this->db = Database::getInstance();
    }
}
```

## 🔧 Query Builder Methods

### SELECT Queries

```php
// Basic SELECT
$users = $this->db->table('users')
    ->select(['id', 'name', 'email'])
    ->where('status', 'active')
    ->orderBy('created_at', 'DESC')
    ->limit(10)
    ->get();

// SELECT với JOIN
$userProfiles = $this->db->table('users')
    ->select(['users.name', 'profiles.phone'])
    ->leftJoin('profiles', 'users.id', '=', 'profiles.user_id')
    ->where('users.status', 'active')
    ->get();

// SELECT với điều kiện phức tạp
$activeUsers = $this->db->table('users')
    ->where('status', 'active')
    ->where('created_at', '>=', '2024-01-01')
    ->whereNotNull('email_verified_at')
    ->whereIn('role', ['admin', 'moderator'])
    ->get();
```

### WHERE Conditions

```php
// Basic WHERE
$this->db->where('status', 'active');
$this->db->where('age', '>', 18);

// WHERE OR
$this->db->where('role', 'admin')
    ->whereOr('role', 'moderator')
    ->whereOr('vip_status', 'premium');

// WHERE IN
$this->db->whereIn('id', [1, 2, 3, 4, 5]);

// WHERE NOT IN
$this->db->whereNotIn('status', ['deleted', 'banned']);

// WHERE NULL
$this->db->whereNull('deleted_at');

// WHERE NOT NULL
$this->db->whereNotNull('email_verified_at');
```

### JOIN Operations

```php
// INNER JOIN
$this->db->join('profiles', 'users.id', '=', 'profiles.user_id');

// LEFT JOIN
$this->db->leftJoin('profiles', 'users.id', '=', 'profiles.user_id');

// RIGHT JOIN
$this->db->rightJoin('profiles', 'users.id', '=', 'profiles.user_id');

// Multiple JOINs
$this->db->leftJoin('profiles', 'users.id', '=', 'profiles.user_id')
    ->leftJoin('roles', 'users.role_id', '=', 'roles.id');
```

### Aggregation & Grouping

```php
// COUNT
$totalUsers = $this->db->table('users')
    ->where('status', 'active')
    ->count();

// EXISTS
$hasAdmin = $this->db->table('users')
    ->where('role', 'admin')
    ->exists();

// GROUP BY với HAVING
$userStats = $this->db->table('users')
    ->select(['role', 'COUNT(*) as count'])
    ->groupBy('role')
    ->having('count', '>', 1)
    ->get();
```

### Ordering & Limiting

```php
// ORDER BY
$this->db->orderBy('created_at', 'DESC');
$this->db->orderBy('name', 'ASC');

// LIMIT & OFFSET
$this->db->limit(10)->offset(20);

// Pagination
$page = 1;
$perPage = 20;
$offset = ($page - 1) * $perPage;

$users = $this->db->table('users')
    ->limit($perPage)
    ->offset($offset)
    ->get();
```

## 📝 CRUD Operations

### INSERT

```php
$userData = [
    'name' => 'John Doe',
    'email' => 'john@example.com',
    'status' => 'active',
    'created_at' => date('Y-m-d H:i:s')
];

$userId = $this->db->table('users')->insert($userData);
echo "Inserted user ID: {$userId}";
```

### UPDATE

```php
$updateData = [
    'status' => 'inactive',
    'updated_at' => date('Y-m-d H:i:s')
];

$updated = $this->db->table('users')
    ->where('id', 1)
    ->update($updateData);

if ($updated) {
    echo "User updated successfully";
}
```

### DELETE

```php
$deleted = $this->db->table('users')
    ->where('id', 1)
    ->delete();

if ($deleted) {
    echo "User deleted successfully";
}
```

## 🔄 Transactions

```php
try {
    $this->db->beginTransaction();

    // Multiple operations
    $userId = $this->db->table('users')->insert($userData);
    $profileId = $this->db->table('profiles')->insert($profileData);

    // If everything is OK, commit
    $this->db->commit();
    echo "Transaction committed successfully";

} catch (\Exception $e) {
    // If error occurs, rollback
    $this->db->rollback();
    echo "Transaction failed: " . $e->getMessage();
}
```

## 🗄️ Raw Queries

```php
// Raw SELECT
$sql = "SELECT u.name, p.phone FROM users u
        LEFT JOIN profiles p ON u.id = p.user_id
        WHERE u.status = ?";
$users = $this->db->queryAll($sql, ['active']);

// Raw INSERT
$insertSql = "INSERT INTO users (name, email) VALUES (?, ?)";
$stmt = $this->db->query($insertSql, ['John', 'john@example.com']);

// Raw UPDATE
$updateSql = "UPDATE users SET status = ? WHERE id = ?";
$stmt = $this->db->query($updateSql, ['inactive', 1]);
```

## 📊 Query Logging

### Bật/Tắt Logging

```php
// Bật logging (mặc định)
$this->db->enableLogging(true);

// Tắt logging để tăng performance
$this->db->enableLogging(false);

// Thay đổi tên bảng log
$this->db->setLogTable('custom_query_logs');
```

### Cấu trúc Bảng Log

```sql
CREATE TABLE query_logs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    sql TEXT NOT NULL,
    params TEXT,
    type VARCHAR(20) NOT NULL,
    table_name VARCHAR(100),
    executed_at DATETIME NOT NULL,
    user_id INT,
    ip_address VARCHAR(45),
    user_agent TEXT,
    error_message TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

### Thông tin được Log

-   **SQL Query**: Câu truy vấn thực thi
-   **Parameters**: Tham số truyền vào
-   **Query Type**: Loại query (SELECT, INSERT, UPDATE, DELETE, RAW)
-   **Table Name**: Tên bảng được truy vấn
-   **Execution Time**: Thời gian thực thi
-   **User Info**: ID user, IP address, User agent
-   **Error Details**: Thông tin lỗi nếu có

## 🛠️ Utility Methods

### Reset Query Builder

```php
// Reset tất cả điều kiện
$this->db->reset();
```

### Debug Information

```php
// Lấy SQL cuối cùng
$lastSql = $this->db->getLastSql();

// Lấy parameters cuối cùng
$lastParams = $this->db->getLastParams();

// In ra để debug
echo "SQL: " . $lastSql;
echo "Params: " . json_encode($lastParams);
```

### Connection Info

```php
$connection = $this->db->getConnection();

// Database info
echo "Driver: " . $connection->getAttribute(\PDO::ATTR_DRIVER_NAME);
echo "Version: " . $connection->getAttribute(\PDO::ATTR_SERVER_VERSION);
```

## 📚 Ví dụ thực tế

### User Management System

```php
class UserController extends Controller
{
    private $db;

    public function __construct()
    {
        parent::__construct();
        $this->db = Database::getInstance();
    }

    // Lấy danh sách users với pagination
    public function getUsers($page = 1, $perPage = 20)
    {
        $offset = ($page - 1) * $perPage;

        $users = $this->db->table('users')
            ->select(['id', 'name', 'email', 'status', 'created_at'])
            ->where('status', '!=', 'deleted')
            ->orderBy('created_at', 'DESC')
            ->limit($perPage)
            ->offset($offset)
            ->get();

        $total = $this->db->table('users')
            ->where('status', '!=', 'deleted')
            ->count();

        return [
            'users' => $users,
            'total' => $total,
            'page' => $page,
            'perPage' => $perPage,
            'totalPages' => ceil($total / $perPage)
        ];
    }

    // Tìm kiếm users
    public function searchUsers($keyword, $filters = [])
    {
        $query = $this->db->table('users')
            ->select(['id', 'name', 'email', 'role', 'status'])
            ->where('status', '!=', 'deleted');

        if (!empty($keyword)) {
            $query->where('name', 'LIKE', "%{$keyword}%")
                  ->whereOr('email', 'LIKE', "%{$keyword}%");
        }

        if (isset($filters['role'])) {
            $query->where('role', $filters['role']);
        }

        if (isset($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        return $query->orderBy('name', 'ASC')->get();
    }

    // Tạo user mới với profile
    public function createUser($userData, $profileData)
    {
        try {
            $this->db->beginTransaction();

            // Insert user
            $userId = $this->db->table('users')->insert($userData);

            // Insert profile
            $profileData['user_id'] = $userId;
            $profileId = $this->db->table('profiles')->insert($profileData);

            $this->db->commit();

            return [
                'success' => true,
                'user_id' => $userId,
                'profile_id' => $profileId
            ];

        } catch (\Exception $e) {
            $this->db->rollback();
            throw $e;
        }
    }
}
```

## ⚡ Performance Tips

1. **Tắt logging trong production** để tăng performance
2. **Sử dụng index** cho các cột thường xuyên query
3. **Limit kết quả** để tránh load quá nhiều data
4. **Sử dụng transactions** cho các operations liên quan
5. **Reset query builder** sau mỗi lần sử dụng

## 🚨 Error Handling

```php
try {
    $users = $this->db->table('users')
        ->where('status', 'active')
        ->get();

} catch (\PDOException $e) {
    // Log error
    error_log("Database error: " . $e->getMessage());

    // Return error response
    return [
        'error' => true,
        'message' => 'Database error occurred'
    ];
}
```

## 🔒 Security Features

-   **Prepared Statements**: Tự động escape parameters
-   **SQL Injection Protection**: Sử dụng PDO với prepared statements
-   **Input Validation**: Validate dữ liệu trước khi query
-   **Error Logging**: Log tất cả errors để debug

## 📖 Best Practices

1. **Luôn sử dụng prepared statements** thay vì string concatenation
2. **Validate input data** trước khi query
3. **Sử dụng transactions** cho operations phức tạp
4. **Log errors** để debug và monitor
5. **Reset query builder** sau mỗi lần sử dụng
6. **Tắt logging** trong production environment
7. **Sử dụng index** cho performance
8. **Limit kết quả** để tránh memory issues

## 🆘 Troubleshooting

### Common Issues

1. **Connection failed**: Kiểm tra DB_HOST, DB_NAME, DB_USER, DB_PASS
2. **Table not found**: Kiểm tra tên bảng và database
3. **Permission denied**: Kiểm tra quyền của database user
4. **Logging failed**: Kiểm tra quyền tạo bảng log

### Debug Mode

```php
// Bật debug mode
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Kiểm tra connection
$connection = $this->db->getConnection();
var_dump($connection->getAttribute(\PDO::ATTR_ERRMODE));
```

## 📞 Support

Nếu gặp vấn đề hoặc cần hỗ trợ, vui lòng:

1. Kiểm tra error logs
2. Verify database configuration
3. Test connection với simple query
4. Contact development team

---

**Database Core** - Powered by LOZIDO Team 🚀
