# 自定义配置（Dcat custom configs）

## 介绍
这是一个基于Dcat Admin的扩展包，用于自定义配置。

## 安装要求
- PHP >= 7.0.0
- Dcat Admin >= 2.0.0

## 安装

```shell
composer require superbad-cn/custom-configs
```

## 使用

### 获取配置
```php
    $key = 'TEST_CONFIG';
    // $key = ['TEST_CONFIG1', 'TEST_CONFIG2'];
    $app = new Dccs();
    $value = $app->get($key);
```

### 设置配置
```php
    $app = new Dccs();
    $app->set('TEST_CONFIG3', '配置内容'); // 设置功能目前只有单条文本，其他类型待开发
```
