<?php
use Cake\Core\Configure;

/**
 * サーバ変数または環境変数から本番・開発環境の区分を取得する。
 * 
 * サーバ変数
 * Apacheの設定に以下を含める。
 * SetEnv CAKE_ENV development
 * 
 * 環境変数
 * ローカルサーバを起動する際に以下のように起動する。
 * env CAKE_ENV=staging ./bin/cake server
 *
 * @author sasaki@tobila
 */
call_user_func(function () {
    // デフォルトの環境設定ファイルを読み込む
    if (file_exists(CONFIG . DS . 'environment.php')) {
        require_once (CONFIG . DS . 'environment.php');
    }
    
    // 環境変数の設定に応じた環境設定ファイルを読み込む
    $_env_dir = CONFIG . DS . 'environments';
    $_env_name = env('CAKE_ENV');
    if (empty($_env_name)) {
        // 環境変数の設定が無い場合は開発環境
        if (file_exists($_env_dir . DS . 'development.php')) {
            require_once ($_env_dir . DS . 'development.php');
        }
        Configure::write('cake_env', 'development');
    } else {
        // 環境変数で指定された環境名の設定ファイルが存在すれば読み込む
        if (file_exists($_env_dir . DS . $_env_name . '.php')) {
            require_once ($_env_dir . DS . $_env_name . '.php');
        }
        Configure::write('cake_env', $_env_name);
    }
    
    // 上書きするための設定を読み込む
    if (file_exists($_env_dir . DS . 'override.php')) {
        require_once ($_env_dir . DS . 'override.php');
    }
});