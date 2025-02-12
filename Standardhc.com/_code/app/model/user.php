<?php
// $Id$

/**
 * User 封装来自 user 数据表的记录及领域逻辑
 */
class User extends QDB_ActiveRecord_Abstract
{
	const UNAUTHORIZED  = 'unauthorized';
	const NORMAL        = 'publish';
	const DELETED       = 'trash';

	// #####################################
	/**
	 * 取得用户角色id和角色名(array)
	 * @param array $tags
	 * @return String
	 */
	static function getRoles($roles)
	{
		if (is_array($roles) || $roles instanceof Iterator)
		{
			$arr = array();
			foreach ($roles as $role)
			{
				$arr[$role->role_id] = $role->rolename;
			}
			$roles = $arr;
		}
		//return trim(implode(' ', Q::normalize($roles, ' ')));
		return $roles;
	}
	/**
	* 设置用户的角色
	* @param mixed $roles
	* 
	$roles = array(
		'0' => '1',
		'1' => '3',
		'2' => '4',
		);
		///这个函数未完成
	*/
	function setRoles($roles)
	{
		$return_value = array();
		foreach ( $roles as $role )
		{
			$return_value[] = Roles::find('rid = ?', $role )->query();
		}
		$this->_props['roles'] = $return_value;
		$this->willChanged('roles');
	}
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
            // 指定该 ActiveRecord 要使用的行为插件
            'behaviors' => 'acluser',

            // 指定行为插件的配置
            'behaviors_settings' => array
            (
                # '插件名' => array('选项' => 设置),
				'acluser' => array
				(
				 	'username_prop' => 'nick',
				 	'encode_type' => 'md5',
					'deleted_prop' => 'is_deleted',
					'acl_data_props' => 'uid, nick, email, roles, status',
					
					'roles_enabled'		=> true,		//是否启用对关联角色的支持，默认值为 false。 
					'roles_prop'		=> 'roles',		//角色信息映射到用户模型的哪一个属性之上。默认值为 roles。
					'roles_name_prop'	=> 'rolename',		//指示角色模型使用哪一个属性保存角色名称，默认值为 name。
					
					'update_login_auto' 	=> true,		//是否在成功调用 validateLogin() 后自动更新用户信息，默认值为 false
					'update_login_count_prop' => 'login_count',	//记录登录次数的属性，不指定则不更新
					'update_login_at_prop'	=> 'last_login',	//记录登录时间的属性，不指定则不更新
					'update_login_ip_prop'	=> 'last_login_ip',	//记录登录 IP 的属性，不指定则不更新

					'register_save_auto' => true,			//是否在新建用户对象时，自动保存下列信息，默认值为 false
					'register_ip_prop' => 'register_ip',		//记录用户的 IP 地址
					'register_at_prop' => 'created',		// 记录创建时间 
				 ),
            ),

            // 用什么数据表保存对象
            'table_name' => 'user',

            // 指定数据表记录字段与对象属性之间的映射关系
            // 没有在此处指定的属性，QeePHP 会自动设置将属性映射为对象的可读写属性
            'props' => array
            (
                // 主键应该是只读，确保领域对象的“不变量”
                'uid' => array('readonly' => true),
				'nick' => array('readonly'=> true),
				'created' 	=> array('readonly' => true),
				'updated' 	=> array('readonly' => true),
                /**
                 *  可以在此添加其他属性的设置
                 */
                # 'other_prop' => array('readonly' => true),
				//'group_name' => array('getter' => 'getGroupName'),
                /**
                 * 添加对象间的关联
                 */
                # 'other' => array('has_one' => 'Class'),
				//'group' => array(QDB::BELONGS_TO => 'Groups','source_key'=>'group_id'),
				//用户拥有一个或者多个角色
				'roles' => array(
					QDB::MANY_TO_MANY=> 'Roles',
					'setter'	 => 'setRoles',
					'mid_source_key' => 'uid',
					'mid_target_key' => 'rid',
					'mid_table_name' => 'user_have_roles'
				),
				//用户除了角色和分组之外还可以拥有多个额外的权限
				/*'permissions' => array(
					QDB::MANY_TO_MANY=> 'Permissions',
					'mid_source_key' => 'uid',
					'mid_target_key' => 'pid',
					'mid_table_name' => 'user_have_permissions'
				),*/
				//'profile' => array(QDB::HAS_ONE => 'Profile','target_key'=>'uid'),
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
            'attr_protected' => 'uid',

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
				'created' => self::AUTOFILL_DATETIME,
				'status' => self::NORMAL,
				'cellphone' => '',
				'language' => 'zh_CN',
            ),

            /**
             * 指定更新数据库中的对象时，哪些属性的值由下面指定的内容进行覆盖
             *
             * 填充值的指定规则同 create_autofill
             */
            'update_autofill' => array
            (
			 	'updated' => self::AUTOFILL_DATETIME,
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
			 	/*
				 * 不能为空
				 * 可选字符:字母数字-_ .  -_.不能出现在开头/末尾 不区分大小写
				 * 
				*/
			 	'nick' => array
				(
					array('min_length',3, '用户名最少3位字符' ),
					array('max_length', 32, '用户名最长32位字符' ),
				),
				
                'email' => array
                (
				 	array('skip_empty'),
					array('is_email',  '请输入一个合法的邮箱地址'),
                    array('max_length', 64, '邮箱地址最多64位字符' ),

                ),

                'password' => array
                (
				 	array('not_empty', '密码未输入' ),
					array('regex','/.{6,20}/', '密码由6-20个字符组成' ),
					//array(array(__CLASS__,'checkPasswordRule'), _T('Password should Mix of letters, numbers, or symbols') ),
                ),


            ),
        );
    }


/*	function getGroupName(){
		$this_group = Groups::find('gid = ?',$this->_props['group_id'])->query();
		return $this_group->group_name;
		//return 'this is the group name------------------------';
	}*/
	
	public static function checkPasswordRule($value)
	{
		if (ctype_digit($value) )
			return false;

		if (ctype_alpha($value) )
			return false;

		return true;
	}
	
	
/*	public static function activeEmail( $email )
	{
		$user = self::find( '[email] = ? ' , $email )->getOne();
		
		if ( $user->id() > 0  )
		{
			//去除未审核组的权限
			$unchecked = Roles::find('rolename = ?','UNCHECKED')->query();
			UserHaveRoles::meta()->destroyWhere('uid = ? AND rid = ?', $user->id(), $unchecked['rid']);
			//获得正常组
			$normal = Roles::find('rolename = ?','NORMAL')->query();
			$user->roles[] = $normal;
			$user->save();
			return $user;
		}
		return false;
	}
*/
	/**
	 *  用户名验证
	 *
	 * @param
	 *
	 * @return
	 */
/*	public static function checkNickCharacters($value)
	{
		//字母数字-_ .  -_.不能出现在开头/末尾 不区分大小写
		$result = preg_match('/^[\-\_\.a-z0-9]+$/',$value) === 0;
		if ($result)
			return false;
		//不允许double
		if ( strpos($value,"--")===false && strpos($value,"__")===false && strpos($value,"..")===false )
			return true;
		else
			return false;
		
	}
	
	public static function checkNickSpecials($value)
	{
		$result = preg_match('/^[\-\_\.]+[\-\_\.a-z0-9]*$/',$value) === 1;
		if($result)
			return false;
		$result = preg_match('/^[\-\_\.a-z0-9]*[\-\_\.]+$/',$value) === 1;
		if($result)
			return false;
		
		return true;
	}*/
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
        return QDB_ActiveRecord_Meta::instance(__CLASS__)->findByArgs($args)->where('is_deleted=0');
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

