<?php

namespace App\Controllers;

use Core\Database;

class DatabaseDemoController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        // Sử dụng Database instance thay vì connection
        $this->db = Database::getInstance();
    }

    /**
     * Demo các tính năng cơ bản của Database Core
     */
    public function index()
    {
        echo "<h1>Database Core Demo - LOZIDO</h1>";
        echo "<h2>1. Query Builder Examples</h2>";
        
        // Demo SELECT queries
        $this->demoSelectQueries();
        
        echo "<h2>2. INSERT/UPDATE/DELETE Examples</h2>";
        
        // Demo CRUD operations
        $this->demoCrudOperations();
        
        echo "<h2>3. Advanced Queries</h2>";
        
        // Demo advanced queries
        $this->demoAdvancedQueries();
        
        echo "<h2>4. Transaction Examples</h2>";
        
        // Demo transactions
        $this->demoTransactions();
        
        echo "<h2>5. Raw Queries</h2>";
        
        // Demo raw queries
        $this->demoRawQueries();
        
        echo "<h2>6. Logging Examples</h2>";
        
        // Demo logging
        $this->demoLogging();
    }

    /**
     * Demo SELECT queries
     */
    private function demoSelectQueries()
    {
        echo "<h3>SELECT Queries:</h3>";
        
        try {
            // Basic SELECT
            echo "<p><strong>1. Basic SELECT:</strong></p>";
            $users = $this->db->table('users')
                ->select(['id', 'name', 'email'])
                ->where('status', 'active')
                ->orderBy('created_at', 'DESC')
                ->limit(5)
                ->get();
            
            echo "<pre>SQL: " . $this->db->getLastSql() . "</pre>";
            echo "<pre>Params: " . json_encode($this->db->getLastParams()) . "</pre>";
            echo "<pre>Results: " . json_encode($users, JSON_PRETTY_PRINT) . "</pre>";
            
            // WHERE conditions
            echo "<p><strong>2. WHERE Conditions:</strong></p>";
            $activeUsers = $this->db->table('users')
                ->where('status', 'active')
                ->where('created_at', '>=', '2024-01-01')
                ->whereNotNull('email_verified_at')
                ->get();
            
            echo "<pre>SQL: " . $this->db->getLastSql() . "</pre>";
            echo "<pre>Results: " . json_encode($activeUsers, JSON_PRETTY_PRINT) . "</pre>";
            
            // WHERE OR conditions
            echo "<p><strong>3. WHERE OR Conditions:</strong></p>";
            $priorityUsers = $this->db->table('users')
                ->where('role', 'admin')
                ->whereOr('role', 'moderator')
                ->whereOr('vip_status', 'premium')
                ->get();
            
            echo "<pre>SQL: " . $this->db->getLastSql() . "</pre>";
            echo "<pre>Results: " . json_encode($priorityUsers, JSON_PRETTY_PRINT) . "</pre>";
            
            // WHERE IN
            echo "<p><strong>4. WHERE IN:</strong></p>";
            $specificUsers = $this->db->table('users')
                ->whereIn('id', [1, 2, 3, 4, 5])
                ->get();
            
            echo "<pre>SQL: " . $this->db->getLastSql() . "</pre>";
            echo "<pre>Results: " . json_encode($specificUsers, JSON_PRETTY_PRINT) . "</pre>";
            
            // JOIN example
            echo "<p><strong>5. JOIN Example:</strong></p>";
            $userProfiles = $this->db->table('users')
                ->select(['users.id', 'users.name', 'users.email', 'profiles.phone', 'profiles.address'])
                ->leftJoin('profiles', 'users.id', '=', 'profiles.user_id')
                ->where('users.status', 'active')
                ->get();
            
            echo "<pre>SQL: " . $this->db->getLastSql() . "</pre>";
            echo "<pre>Results: " . json_encode($userProfiles, JSON_PRETTY_PRINT) . "</pre>";
            
            // COUNT
            echo "<p><strong>6. COUNT:</strong></p>";
            $totalUsers = $this->db->table('users')
                ->where('status', 'active')
                ->count();
            
            echo "<pre>Total Active Users: {$totalUsers}</pre>";
            
            // EXISTS
            echo "<p><strong>7. EXISTS:</strong></p>";
            $hasAdmin = $this->db->table('users')
                ->where('role', 'admin')
                ->exists();
            
            echo "<pre>Has Admin Users: " . ($hasAdmin ? 'Yes' : 'No') . "</pre>";
            
            // FIRST
            echo "<p><strong>8. FIRST:</strong></p>";
            $firstUser = $this->db->table('users')
                ->orderBy('created_at', 'ASC')
                ->first();
            
            echo "<pre>First User: " . json_encode($firstUser, JSON_PRETTY_PRINT) . "</pre>";
            
            // VALUE
            echo "<p><strong>9. VALUE:</strong></p>";
            $userName = $this->db->table('users')
                ->where('id', 1)
                ->value('name');
            
            echo "<pre>User Name (ID=1): {$userName}</pre>";
            
        } catch (\Exception $e) {
            echo "<p style='color: red;'>Error: " . $e->getMessage() . "</p>";
        }
        
        // Reset query builder
        $this->db->reset();
    }

    /**
     * Demo CRUD operations
     */
    private function demoCrudOperations()
    {
        echo "<h3>CRUD Operations:</h3>";
        
        try {
            // INSERT
            echo "<p><strong>1. INSERT:</strong></p>";
            $insertData = [
                'name' => 'Demo User',
                'email' => 'demo@example.com',
                'status' => 'active',
                'created_at' => date('Y-m-d H:i:s')
            ];
            
            $userId = $this->db->table('users')->insert($insertData);
            echo "<pre>Inserted User ID: {$userId}</pre>";
            
            // UPDATE
            echo "<p><strong>2. UPDATE:</strong></p>";
            $updateData = [
                'status' => 'inactive',
                'updated_at' => date('Y-m-d H:i:s')
            ];
            
            $updated = $this->db->table('users')
                ->where('id', $userId)
                ->update($updateData);
            
            echo "<pre>Updated: " . ($updated ? 'Success' : 'Failed') . "</pre>";
            
            // DELETE
            echo "<p><strong>3. DELETE:</strong></p>";
            $deleted = $this->db->table('users')
                ->where('id', $userId)
                ->delete();
            
            echo "<pre>Deleted: " . ($deleted ? 'Success' : 'Failed') . "</pre>";
            
        } catch (\Exception $e) {
            echo "<p style='color: red;'>Error: " . $e->getMessage() . "</p>";
        }
        
        // Reset query builder
        $this->db->reset();
    }

    /**
     * Demo advanced queries
     */
    private function demoAdvancedQueries()
    {
        echo "<h3>Advanced Queries:</h3>";
        
        try {
            // GROUP BY with HAVING
            echo "<p><strong>1. GROUP BY with HAVING:</strong></p>";
            $userStats = $this->db->table('users')
                ->select(['role', 'COUNT(*) as count'])
                ->groupBy('role')
                ->having('count', '>', 1)
                ->get();
            
            echo "<pre>SQL: " . $this->db->getLastSql() . "</pre>";
            echo "<pre>Results: " . json_encode($userStats, JSON_PRETTY_PRINT) . "</pre>";
            
            // Complex JOIN with multiple conditions
            echo "<p><strong>2. Complex JOIN:</strong></p>";
            $userOrders = $this->db->table('users')
                ->select(['users.name', 'orders.order_number', 'orders.total_amount'])
                ->join('orders', 'users.id', '=', 'orders.user_id')
                ->where('orders.status', 'completed')
                ->where('orders.total_amount', '>', 1000)
                ->orderBy('orders.total_amount', 'DESC')
                ->limit(10)
                ->get();
            
            echo "<pre>SQL: " . $this->db->getLastSql() . "</pre>";
            echo "<pre>Results: " . json_encode($userOrders, JSON_PRETTY_PRINT) . "</pre>";
            
            // Subquery equivalent with multiple WHERE conditions
            echo "<p><strong>3. Multiple WHERE Conditions:</strong></p>";
            $premiumUsers = $this->db->table('users')
                ->where('status', 'active')
                ->where('role', '!=', 'guest')
                ->where('created_at', '>=', '2024-01-01')
                ->where('last_login', '>=', date('Y-m-d', strtotime('-30 days')))
                ->whereNotNull('email_verified_at')
                ->orderBy('last_login', 'DESC')
                ->get();
            
            echo "<pre>SQL: " . $this->db->getLastSql() . "</pre>";
            echo "<pre>Results: " . json_encode($premiumUsers, JSON_PRETTY_PRINT) . "</pre>";
            
        } catch (\Exception $e) {
            echo "<p style='color: red;'>Error: " . $e->getMessage() . "</p>";
        }
        
        // Reset query builder
        $this->db->reset();
    }

    /**
     * Demo transactions
     */
    private function demoTransactions()
    {
        echo "<h3>Transactions:</h3>";
        
        try {
            $this->db->beginTransaction();
            
            echo "<p>Transaction started...</p>";
            
            // Multiple operations in transaction
            $userData = [
                'name' => 'Transaction User',
                'email' => 'transaction@example.com',
                'status' => 'active',
                'created_at' => date('Y-m-d H:i:s')
            ];
            
            $userId = $this->db->table('users')->insert($userData);
            echo "<p>Inserted user ID: {$userId}</p>";
            
            $profileData = [
                'user_id' => $userId,
                'phone' => '0123456789',
                'address' => 'Demo Address',
                'created_at' => date('Y-m-d H:i:s')
            ];
            
            $profileId = $this->db->table('profiles')->insert($profileData);
            echo "<p>Inserted profile ID: {$profileId}</p>";
            
            // Simulate some condition to decide commit or rollback
            $shouldCommit = true; // Change this to test rollback
            
            if ($shouldCommit) {
                $this->db->commit();
                echo "<p style='color: green;'>Transaction committed successfully!</p>";
            } else {
                $this->db->rollback();
                echo "<p style='color: orange;'>Transaction rolled back!</p>";
            }
            
        } catch (\Exception $e) {
            $this->db->rollback();
            echo "<p style='color: red;'>Transaction error: " . $e->getMessage() . " - Rolled back</p>";
        }
    }

    /**
     * Demo raw queries
     */
    private function demoRawQueries()
    {
        echo "<h3>Raw Queries:</h3>";
        
        try {
            // Raw SELECT
            echo "<p><strong>1. Raw SELECT:</strong></p>";
            $sql = "SELECT u.name, u.email, p.phone 
                    FROM users u 
                    LEFT JOIN profiles p ON u.id = p.user_id 
                    WHERE u.status = ? 
                    ORDER BY u.created_at DESC 
                    LIMIT 5";
            
            $users = $this->db->queryAll($sql, ['active']);
            echo "<pre>SQL: " . $sql . "</pre>";
            echo "<pre>Results: " . json_encode($users, JSON_PRETTY_PRINT) . "</pre>";
            
            // Raw INSERT
            echo "<p><strong>2. Raw INSERT:</strong></p>";
            $insertSql = "INSERT INTO users (name, email, status, created_at) VALUES (?, ?, ?, ?)";
            $insertParams = ['Raw User', 'raw@example.com', 'active', date('Y-m-d H:i:s')];
            
            $stmt = $this->db->query($insertSql, $insertParams);
            echo "<pre>Raw INSERT executed successfully</pre>";
            
            // Raw UPDATE
            echo "<p><strong>3. Raw UPDATE:</strong></p>";
            $updateSql = "UPDATE users SET status = ?, updated_at = ? WHERE email = ?";
            $updateParams = ['inactive', date('Y-m-d H:i:s'), 'raw@example.com'];
            
            $stmt = $this->db->query($updateSql, $updateParams);
            echo "<pre>Raw UPDATE executed successfully</pre>";
            
        } catch (\Exception $e) {
            echo "<p style='color: red;'>Error: " . $e->getMessage() . "</p>";
        }
    }

    /**
     * Demo logging
     */
    private function demoLogging()
    {
        echo "<h3>Query Logging:</h3>";
        
        try {
            // Enable logging
            $this->db->enableLogging(true);
            $this->db->setLogTable('query_logs');
            
            echo "<p>Logging enabled. All queries will be logged to 'query_logs' table.</p>";
            
            // Execute some queries to generate logs
            $this->db->table('users')
                ->select(['id', 'name'])
                ->where('status', 'active')
                ->limit(3)
                ->get();
            
            echo "<p>Query executed and logged. Check the 'query_logs' table for details.</p>";
            
            // Show log table structure
            echo "<p><strong>Log Table Structure:</strong></p>";
            echo "<pre>
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
            </pre>";
            
            // Disable logging for performance
            $this->db->enableLogging(false);
            echo "<p>Logging disabled for performance.</p>";
            
        } catch (\Exception $e) {
            echo "<p style='color: red;'>Error: " . $e->getMessage() . "</p>";
        }
    }

    /**
     * Test database connection
     */
    public function testConnection()
    {
        try {
            $connection = $this->db->getConnection();
            echo "<h2>Database Connection Test</h2>";
            echo "<p style='color: green;'>✅ Database connection successful!</p>";
            echo "<p><strong>Database Info:</strong></p>";
            echo "<ul>";
            echo "<li>Host: " . DB_HOST . "</li>";
            echo "<li>Database: " . DB_NAME . "</li>";
            echo "<li>User: " . DB_USER . "</li>";
            echo "<li>PDO Driver: " . $connection->getAttribute(\PDO::ATTR_DRIVER_NAME) . "</li>";
            echo "<li>Server Version: " . $connection->getAttribute(\PDO::ATTR_SERVER_VERSION) . "</li>";
            echo "</ul>";
        } catch (\Exception $e) {
            echo "<h2>Database Connection Test</h2>";
            echo "<p style='color: red;'>❌ Database connection failed: " . $e->getMessage() . "</p>";
        }
    }
}
