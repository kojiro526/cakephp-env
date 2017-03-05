# Environments plugin for CakePHP

## 概要

サーバ変数または環境変数で設定した名前に応じて設定ファイルを切り替えるプラグインです。

## 必要環境

- CakePHP 3.x

## インストール

composerで以下のようにインストールします。

予め、このリポジトリをcomposer.jsonに追加しておく必要があります。
```
# composer.json に以下を追記
{
==(略)==
    "repositories": [
        {↲
            "type": "git",↲
            "url": "https://bitbucket.org/kojiro526/cakephp-env.git"↲
        }
    ],↲
==(略)==
```

以下のコマンドでインストールします。

```
composer require kojiro526/cakephp-env
```

インストール後、`config/bootstrap.php`に以下を追記します。

```
Plugin::load('Environments', ['bootstrap' => true]);
```

## 使い方

`config/`ディレクトリ配下に以下の設定ファイルを配置します。

```
config/
    ┣ environment.php
    ┗ environments/
```

`environment.php`は常に読み込まれます。全ての環境に共通の設定などを記載します。

`environments`ディレクトリ配下に配置したファイルは、名前によって以下のように読み込まれます。
1. `development.php`という名前で作成したファイルは、サーバ変数や環境変数で環境名の設定がされていない場合に読み込まれます。 
2. `override.php`という名前で作成したファイルは、上記の`development.php`や下記の環境名で指定された設定ファイルを読み込んだ後に読み込まれます。
    - 各開発担当者がローカル環境上で他のファイルの設定を上書きする用途などで用います。
3. それ以外の名前で作成したファイルは、同一の環境名が設定されている場合に読み込まれます。
    - 例えば、`config/environments/staging.php`というファイルは、サーバ変数や環境変数で`CAKE_ENV=staging`が設定された場合に読み込まれます。

### 環境名の設定

環境名は、Webサーバのサーバ変数やOSの環境変数で`CAKE_ENV`という名前で指定します。

#### ローカルサーバを立ち上げる場合

```
env CAKE_ENV=production ./bin/cake server
```

#### Apacheで設定する場合

サーバの設定に以下の設定を追記します。

```
SetEnv CAKE_ENV development
```

### 環境名の取得

現在の環境名は以下のように取得できます。
```
Configure::read('Environments.env_name')
```
