<?php
// $Id: roles.php @2009 ccbox.net 1:22 2009-5-14 $
# role_id rolename description user_owned group_owned
/**
 * Roles 封装来自 sys_acl_roles 数据表的记录及领域逻辑
 */
class Roles extends QDB_ActiveRecord_Abstract
{

    /**
     * 返回对象的定义
     *
     * @static
     *
     * @return array
     */
    static function __define()
    {
        return array
        (
            // 指定该 ActiveRecord 要使用的行为插件
            'behaviors' => 'uniqueness',

            // 指定行为插件的配置
            'behaviors_settings' => array
            (
                # '插件名' => array('选项' => 设置),
                'uniqueness' => array(
                    'check_props' => 'rolename',
                    'error_messages' => array('rolename' => '角色名已经存在'),
                ),
            ),

            // 用什么数据表保存对象
            'table_name' => 'roles',

            // 指定数据表记录字段与对象属性之间的映射关系
            // 没有在此处指定的属性，QeePHP 会自动设置将属性映射为对象的可读写属性
            'props' => array
            (
                // 主键应该是只读，确保领域对象的“不变量”
                'rid' => array('readonly' => true),

                /**
                 *  可以在此添加其他属性的设置
                 */
                # 'other_prop' => array('readonly' => true),

                /**
                 * 添加对象间的关联
                 */
                # 'other' => array('has_one' => 'Class'),

                // ***************** ACL部分关联开始 *****************
                //角色对应一个或者多个用户
                'users' => array(
                    QDB::MANY_TO_MANY => 'User',
                    'mid_source_key' => 'rid',
                    'mid_target_key' => 'uid',
                    'mid_table_name' => 'user_have_roles',
					'on_find_where' => 'is_deleted=0',
                ),
                //角色对应一个或者多个组
/*                'groups' => array(
                    QDB::MANY_TO_MANY => 'Groups',
                    'mid_source_key' => 'rid',
                    'mid_target_key' => 'gid',
                    'mid_table_name' => 'groups_have_roles'
                ),*/
                //角色对应一个或者多个权限
                'permissions' => array(
                    QDB::MANY_TO_MANY => 'Frame',
                    'mid_source_key' => 'rid',
                    'mid_target_key' => 'fid',
                    'mid_table_name' => 'roles_have_permissions'
                ),
                // ***************** ACL部分关联结束 *****************
            ),

            /**
             * 允许使用 mass-assignment 方式赋值的属性
             *
             * 如果指定了 attr_accessible，则忽略 attr_protected 的设置。
             */
            'attr_accessible' => '',

            /**
             * 拒绝使用 mass-assignment 方式赋值的属性
             */
            'attr_protected' => 'rid',

            /**
             * 指定在数据库中创建对象时，哪些属性的值不允许由外部提供
             *
             * 这里指定的属性会在创建记录时被过滤掉，从而让数据库自行填充值。
             */
            'create_reject' => '',

            /**
             * 指定更新数据库中的对象时，哪些属性的值不允许由外部提供
             */
            'update_reject' => '',

            /**
             * 指定在数据库中创建对象时，哪些属性的值由下面指定的内容进行覆盖
             *
             * 如果填充值为 self::AUTOFILL_TIMESTAMP 或 self::AUTOFILL_DATETIME，
             * 则会根据属性的类型来自动填充当前时间（整数或字符串）。
             *
             * 如果填充值为一个数组，则假定为 callback 方法。
             */
            'create_autofill' => array
            (
                # 属性名 => 填充值
                # 'is_locked' => 0,
                'user_owned' => 0,
                'group_owned' => 0,
            ),

            /**
             * 指定更新数据库中的对象时，哪些属性的值由下面指定的内容进行覆盖
             *
             * 填充值的指定规则同 create_autofill
             */
            'update_autofill' => array
            (
            ),

            /**
             * 在保存对象时，会按照下面指定的验证规则进行验证。验证失败会抛出异常。
             *
             * 除了在保存时自动验证，还可以通过对象的 ::meta()->validate() 方法对数组数据进行验证。
             *
             * 如果需要添加一个自定义验证，应该写成
             *
             * 'title' => array(
             *        array(array(__CLASS__, 'checkTitle'), '标题不能为空'),
             * )
             *
             * 然后在该类中添加 checkTitle() 方法。函数原型如下：
             *
             * static function checkTitle($title)
             *
             * 该方法返回 true 表示通过验证。
             */
            'validations' => array
            (
                'rolename' => array
                (
                    array('not_empty', '组名称不能为空'),
                    array('max_length', 50, '组名称不能超过 50 个字符'),
                    array('is_alnumu', '登录帐号名只能由字母(建议大写)、数字或下划线组成'),
                ),

                'description' => array
                (
                    array('not_empty', '组说明不能为空'),
                    array('max_length', 240, '组说明不能超过 240 个字符'),
                ),

                'user_owned' => array
                (
                    array('skip_empty'),
                    array('is_int', '组用户量必须是一个整数'),
                ),

                'group_owned' => array
                (
                    array('skip_empty'),
                    array('is_int', '组用户组量必须是一个整数'),
                ),


            ),
        );
    }
	
	protected function _before_save()
	{
		$this->rolename = strtoupper($this->rolename);
	}

/* ------------------ 以下是自动生成的代码，不能修改 ------------------ */

    /**
     * 开启一个查询，查找符合条件的对象或对象集合
     *
     * @static
     *
     * @return QDB_Select
     */
    static function find()
    {
        $args = func_get_args();
        return QDB_ActiveRecord_Meta::instance(__CLASS__)->findByArgs($args);
    }

    /**
     * 返回当前 ActiveRecord 类的元数据对象
     *
     * @static
     *
     * @return QDB_ActiveRecord_Meta
     */
    static function meta()
    {
        return QDB_ActiveRecord_Meta::instance(__CLASS__);
    }


/* ------------------ 以上是自动生成的代码，不能修改 ------------------ */

}

