<?php
/**
 * Created by PhpStorm.
 * User: xzjs
 * Date: 16/2/26
 * Time: 下午4:43
 */
namespace Home\Controller;

class CommandControllerTest extends \PHPUnit_Framework_TestCase
{
    use \Think\PhpUnit; // 只有控制器测试类才需要它

    static public function setupBeforeClass()
    {
        // 下面四行代码模拟出一个应用实例, 每一行都很关键, 需正确设置参数
        self::$app = new \Think\PhpunitHelper();
        self::$app->setMVC('localhost', 'Home', 'Command');
        self::$app->setTestConfig(['DB_TYPE' => 'mysql', // 数据库类型
            'DB_HOST' => '192.168.4.96', // 服务器地址
            'DB_NAME' => 'bus_wifidb', // 数据库名
            'DB_USER' => 'root', // 用户名
            'DB_PWD' => '123', // 密码
            'DB_PORT' => 3306, // 端口
            'DB_PREFIX' => 'think_', // 数据库表前缀
            'DB_CHARSET' => 'utf8', // 字符集
            'DB_DEBUG' => TRUE, // 数据库调试模式 开启后可以记录SQL日志
        ]); // 一定要设置一个测试用的数据库,避免测试过程破坏生产数据
        self::$app->start();
    }

    public function testAuto_limit()
    {
        $data = array(
            'device_id' => 83,
            'num' => 3 * 1024 * 1024,
            'mac' => '2e:60:ed:d8:3d:0a'
        );
        $output = $this->execAction('addFlow', $data);
        $this->execAction('auto_limit', $data);
        $d = $this->execAction('getDevice', $data);
        var_dump($d);
        $this->assertEquals($d['network_limit'], 0);
    }
}