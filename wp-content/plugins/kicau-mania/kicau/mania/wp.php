<?php
/**
 * ========================================
 * WORDPRESS SECURITY CLEANER v2.0
 * ========================================
 * Fitur:
 * - Auto-detect wp-config.php
 * - Hapus plugin file manager berbahaya
 * - Hardening wp-config.php dengan security defines
 * - Log aktivitas detail
 * - Verifikasi permission
 * - Scan malicious files di plugin
 * ========================================
 */

set_time_limit(300);
ini_set('display_errors', 1);
error_reporting(E_ALL);

// 🎨 CSS untuk tampilan
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WordPress Security Cleaner</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { 
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 20px;
            min-height: 100vh;
        }
        .container { 
            max-width: 900px; 
            margin: 0 auto; 
            background: white;
            border-radius: 12px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
            overflow: hidden;
        }
        .header {
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
            color: white;
            padding: 30px;
            text-align: center;
        }
        .header h1 { font-size: 28px; margin-bottom: 10px; }
        .header p { opacity: 0.9; font-size: 14px; }
        .content { padding: 30px; }
        .alert {
            padding: 15px 20px;
            border-radius: 8px;
            margin-bottom: 20px;
            border-left: 4px solid;
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .alert-success { background: #d4edda; border-color: #28a745; color: #155724; }
        .alert-danger { background: #f8d7da; border-color: #dc3545; color: #721c24; }
        .alert-warning { background: #fff3cd; border-color: #ffc107; color: #856404; }
        .alert-info { background: #d1ecf1; border-color: #17a2b8; color: #0c5460; }
        .log-item {
            padding: 12px 15px;
            background: #f8f9fa;
            border-left: 3px solid #007bff;
            margin-bottom: 10px;
            border-radius: 4px;
            font-size: 14px;
            font-family: 'Courier New', monospace;
        }
        .log-item.success { border-color: #28a745; background: #d4edda; }
        .log-item.error { border-color: #dc3545; background: #f8d7da; }
        .log-item.warning { border-color: #ffc107; background: #fff3cd; }
        .stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
            margin: 20px 0;
        }
        .stat-box {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 20px;
            border-radius: 8px;
            text-align: center;
        }
        .stat-box .number { font-size: 32px; font-weight: bold; }
        .stat-box .label { font-size: 14px; opacity: 0.9; margin-top: 5px; }
        .section {
            margin: 25px 0;
            padding: 20px;
            background: #f8f9fa;
            border-radius: 8px;
        }
        .section h2 {
            font-size: 18px;
            margin-bottom: 15px;
            color: #333;
            border-bottom: 2px solid #007bff;
            padding-bottom: 10px;
        }
        code {
            background: #e9ecef;
            padding: 2px 6px;
            border-radius: 3px;
            font-family: 'Courier New', monospace;
            font-size: 13px;
        }
        .footer {
            background: #f8f9fa;
            padding: 20px;
            text-align: center;
            font-size: 13px;
            color: #666;
            border-top: 1px solid #dee2e6;
        }
        .icon { font-size: 20px; }
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <h1>🛡️ WordPress Security Cleaner</h1>
        <p>Automated WordPress Security & Cleanup Tool</p>
    </div>
    <div class="content">
<?php

// ==================== CONFIGURATION ====================

$config = [
    // Plugin file manager yang akan dihapus
    'target_plugins' => [
        'wp-file-manager', 'file-manager', 'advanced-file-manager',
        'filester', 'wp-file-manager-pro', 'real-file-manager',
        'filebird', 'wicked-folders', 'media-library-folders',
        'wp-media-folder', 'file-manager-advanced', 'simple-file-manager',
        'file-organizer', 'wp-file-organizer', 'fileorganizer',
        'smart-file-manager', 'file-manager-woocommerce', 'wp-filebase',
        'media-library-folder', 'folder-manager', 'wp-folders',
        'frontend-file-manager', 'wp-file-manager-backup', 'fm-backup',
        'wp-content-crawler', 'file-manager-admin', 'wordpress-file-upload',
        'download-manager', 'simple-download-monitor', 'wpdm-file-manager'
    ],
    
    // Security defines untuk wp-config.php
    'security_defines' => [
        "DISALLOW_FILE_EDIT" => true,
        "DISALLOW_FILE_MODS" => true,
        "FORCE_SSL_ADMIN" => true,
        "WP_AUTO_UPDATE_CORE" => 'minor',
        "AUTOMATIC_UPDATER_DISABLED" => false,
    ],
    
    // Suspicious patterns dalam file
    'malicious_patterns' => [
        'eval(', 'base64_decode(', 'gzinflate(', 'str_rot13(',
        'system(', 'exec(', 'shell_exec(', 'passthru(',
        'assert(', 'create_function(', 'preg_replace.*\/e',
        '\$_GET', '\$_POST', '\$_REQUEST', '\$_COOKIE'
    ],
    
    'scan_malicious' => true,
    'max_search_depth' => 15
];

// ==================== MAIN EXECUTION ====================

$stats = [
    'deleted' => 0,
    'failed' => 0,
    'scanned' => 0,
    'suspicious' => 0
];

$log = [];

// 🔍 Step 1: Find wp-config.php
add_log('info', '🔍 Mencari wp-config.php...');
$wp_config = find_wp_config($config['max_search_depth']);

if (!$wp_config) {
    add_log('error', '❌ wp-config.php tidak ditemukan!');
    show_alert('danger', '❌ Error', 'File wp-config.php tidak ditemukan. Pastikan script dijalankan di dalam folder WordPress.');
    show_logs();
    exit;
}

$wp_root = dirname($wp_config);
add_log('success', "✅ WordPress ditemukan di: <code>$wp_root</code>");
add_log('success', "✅ wp-config.php: <code>$wp_config</code>");

// 🔐 Step 2: Hardening wp-config.php
add_log('info', '🔐 Menerapkan security hardening...');
$hardening_result = harden_wp_config($wp_config, $config['security_defines']);
if ($hardening_result['success']) {
    add_log('success', "✅ Security defines ditambahkan: " . $hardening_result['added'] . " item");
} else {
    add_log('error', "❌ Gagal hardening: " . $hardening_result['error']);
}

// 🗑️ Step 3: Delete target plugins
$plugins_dir = "$wp_root/wp-content/plugins";

if (!is_dir($plugins_dir)) {
    add_log('error', "❌ Folder plugins tidak ditemukan: <code>$plugins_dir</code>");
    show_alert('danger', '❌ Error', 'Folder wp-content/plugins tidak ditemukan.');
    show_logs();
    exit;
}

add_log('info', '🧹 Memulai penghapusan plugin berbahaya...');

foreach ($config['target_plugins'] as $plugin) {
    $plugin_path = "$plugins_dir/$plugin";
    $stats['scanned']++;
    
    if (is_dir($plugin_path)) {
        // Scan for malicious files
        if ($config['scan_malicious']) {
            $suspicious = scan_malicious_files($plugin_path, $config['malicious_patterns']);
            if (count($suspicious) > 0) {
                add_log('warning', "⚠️ <b>$plugin</b> - Ditemukan " . count($suspicious) . " file mencurigakan");
                $stats['suspicious'] += count($suspicious);
            }
        }
        
        // Delete plugin
        add_log('info', "🗑️ Menghapus: <b>$plugin</b>...");
        $delete_result = delete_folder($plugin_path);
        
        if ($delete_result['success']) {
            add_log('success', "✅ <b>$plugin</b> berhasil dihapus (" . $delete_result['files'] . " files)");
            $stats['deleted']++;
        } else {
            add_log('error', "❌ <b>$plugin</b> gagal dihapus: " . $delete_result['error']);
            $stats['failed']++;
        }
    }
}

// 📊 Show Results
echo '<div class="stats">';
echo '<div class="stat-box"><div class="number">' . $stats['scanned'] . '</div><div class="label">Plugin Dipindai</div></div>';
echo '<div class="stat-box"><div class="number">' . $stats['deleted'] . '</div><div class="label">Plugin Dihapus</div></div>';
echo '<div class="stat-box"><div class="number">' . $stats['suspicious'] . '</div><div class="label">File Mencurigakan</div></div>';
echo '<div class="stat-box"><div class="number">' . $stats['failed'] . '</div><div class="label">Gagal Dihapus</div></div>';
echo '</div>';

// Show final alert
if ($stats['deleted'] > 0) {
    show_alert('success', '✅ Selesai!', "Berhasil menghapus {$stats['deleted']} plugin berbahaya.");
} else {
    show_alert('info', 'ℹ️ Info', 'Tidak ada plugin berbahaya yang ditemukan.');
}

// Show warning if there are failed deletions
if ($stats['failed'] > 0) {
    show_alert('warning', '⚠️ Perhatian', "Ada {$stats['failed']} plugin yang gagal dihapus. Periksa permission folder.");
}

// Show logs
show_logs();

// ==================== FUNCTIONS ====================

/**
 * Find wp-config.php by searching upward
 */
function find_wp_config($max_depth = 15) {
    $dir = __DIR__;
    
    for ($i = 0; $i < $max_depth; $i++) {
        $config_path = "$dir/wp-config.php";
        
        if (file_exists($config_path) && is_readable($config_path)) {
            return $config_path;
        }
        
        $parent = dirname($dir);
        
        // Reached server root
        if ($parent === $dir) {
            break;
        }
        
        $dir = $parent;
    }
    
    return false;
}

/**
 * Harden wp-config.php with security defines
 */
function harden_wp_config($config_path, $defines) {
    $result = ['success' => false, 'added' => 0, 'error' => ''];
    
    if (!is_readable($config_path) || !is_writable($config_path)) {
        $result['error'] = 'File tidak dapat dibaca/ditulis';
        return $result;
    }
    
    $content = @file_get_contents($config_path);
    
    if ($content === false) {
        $result['error'] = 'Gagal membaca file';
        return $result;
    }
    
    $additions = "\n/* Security Hardening - Added by Security Cleaner */\n";
    $added = 0;
    
    foreach ($defines as $key => $value) {
        $define_line = create_define_line($key, $value);
        
        // Check if define already exists
        if (preg_match("/define\s*\(\s*['\"]" . preg_quote($key, '/') . "['\"]/i", $content)) {
            continue; // Already exists
        }
        
        $additions .= $define_line . "\n";
        $added++;
    }
    
    if ($added > 0) {
        // Insert before the "stop editing" comment
        if (preg_match("/(\/\*.*stop editing.*\*\/)/i", $content, $matches)) {
            $content = str_replace($matches[1], $additions . $matches[1], $content);
        } else {
            // Just append if no stop editing comment found
            $content .= $additions;
        }
        
        if (@file_put_contents($config_path, $content) !== false) {
            $result['success'] = true;
            $result['added'] = $added;
        } else {
            $result['error'] = 'Gagal menulis file';
        }
    } else {
        $result['success'] = true;
        $result['added'] = 0;
    }
    
    return $result;
}

/**
 * Create define line based on value type
 */
function create_define_line($key, $value) {
    if (is_bool($value)) {
        $val = $value ? 'true' : 'false';
    } elseif (is_string($value)) {
        $val = "'" . addslashes($value) . "'";
    } elseif (is_numeric($value)) {
        $val = $value;
    } else {
        $val = var_export($value, true);
    }
    
    return "define('{$key}', {$val});";
}

/**
 * Scan folder for malicious patterns
 */
function scan_malicious_files($dir, $patterns) {
    $suspicious = [];
    
    if (!is_dir($dir)) {
        return $suspicious;
    }
    
    $iterator = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($dir, RecursiveDirectoryIterator::SKIP_DOTS),
        RecursiveIteratorIterator::SELF_FIRST
    );
    
    foreach ($iterator as $file) {
        if ($file->isFile() && preg_match('/\.(php|js)$/i', $file->getFilename())) {
            $content = @file_get_contents($file->getPathname());
            
            if ($content !== false) {
                foreach ($patterns as $pattern) {
                    if (stripos($content, $pattern) !== false) {
                        $suspicious[] = $file->getPathname();
                        break;
                    }
                }
            }
        }
    }
    
    return $suspicious;
}

/**
 * Delete folder recursively with error handling
 */
function delete_folder($dir) {
    $result = ['success' => false, 'files' => 0, 'error' => ''];
    
    if (!is_dir($dir)) {
        $result['error'] = 'Bukan direktori';
        return $result;
    }
    
    try {
        @chmod($dir, 0777);
        
        $items = @scandir($dir);
        
        if ($items === false) {
            $result['error'] = 'Tidak dapat membaca direktori';
            return $result;
        }
        
        $items = array_diff($items, ['.', '..']);
        
        foreach ($items as $item) {
            $path = "$dir/$item";
            
            if (is_dir($path)) {
                $sub_result = delete_folder($path);
                $result['files'] += $sub_result['files'];
            } else {
                @chmod($path, 0666);
                if (@unlink($path)) {
                    $result['files']++;
                }
            }
        }
        
        if (@rmdir($dir)) {
            $result['success'] = true;
        } else {
            $result['error'] = 'Gagal menghapus direktori utama';
        }
        
    } catch (Exception $e) {
        $result['error'] = $e->getMessage();
    }
    
    return $result;
}

/**
 * Add log entry
 */
function add_log($type, $message) {
    global $log;
    $log[] = ['type' => $type, 'message' => $message, 'time' => date('H:i:s')];
}

/**
 * Show alert box
 */
function show_alert($type, $title, $message) {
    $icons = [
        'success' => '✅',
        'danger' => '❌',
        'warning' => '⚠️',
        'info' => 'ℹ️'
    ];
    
    echo '<div class="alert alert-' . $type . '">';
    echo '<span class="icon">' . $icons[$type] . '</span>';
    echo '<div><strong>' . $title . '</strong><br>' . $message . '</div>';
    echo '</div>';
}

/**
 * Display all logs
 */
function show_logs() {
    global $log;
    
    if (empty($log)) {
        return;
    }
    
    echo '<div class="section">';
    echo '<h2>📋 Log Aktivitas</h2>';
    
    foreach ($log as $entry) {
        $class = '';
        
        switch ($entry['type']) {
            case 'success':
                $class = 'success';
                break;
            case 'error':
                $class = 'error';
                break;
            case 'warning':
                $class = 'warning';
                break;
            default:
                $class = '';
        }
        
        echo '<div class="log-item ' . $class . '">';
        echo '[' . $entry['time'] . '] ' . $entry['message'];
        echo '</div>';
    }
    
    echo '</div>';
}

?>
    </div>
    <div class="footer">
        <p>WordPress Security Cleaner v2.0 | Generated <?= date('Y-m-d H:i:s') ?></p>
    </div>
</div>
</body>
</html>