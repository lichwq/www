<?php
namespace Home\Model;
use Think\Model;

class  MysqlModel  extends Model {
    // 定义自动验证
    protected $_validate    =   array(
        array('from_user','require','from_user必须'),
        );
    // 定义自动完成
    protected $_auto    =   array(
        array('update_time','time',date("Y-m-d G:i:s"),'function'),
        );
}