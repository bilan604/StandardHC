<?php
// $Id: Acl.php @2009 ccbox.net 1:22 2009-5-14 $
/**
 * 用户权限处理类
**/
class Helper_Acl
{
    /* ******************************************************************** */
    /**
    * 判定用户的权限，并根据用户的状态进行角色转换
    * @param mixed $uid 要获取的用户的ID
    */
    /*
sp_role:
  ROOT: "ROOT"
  ADMIN: "ADMIN"
  NORMAL: "NORMAL"
  FREEZE: "FREEZE"
  REPEAL: "REPEAL"
  UNCHECKED: "UNCHECKED"
  Q::ini('appini/sp_role/UNCHECKED')*/ 
  
    function UserAclRoles( $uid = '' )
    {
        $show_box['title'] = '获取用户全部角色';
        $return_value = '';
        $roles_idname = array();
        $roles_id = array();
        $sp_roles = Q::ini('appini/sp_role');

        // 第一步：直接从中间表获得用户的全部角色ID
        $user_roles =  UserHaveRoles::find('uid = ?',intval($uid) )->asArray()->getAll();
        //dump($user_roles);

        // 取出有用的ID，去除deny的ID
        foreach ($user_roles as $value){
            if ($value['is_include']){
                $roles_id[] = $value['rid'];
            }
        }
        //dump ( $roles_id);
		if( empty($roles_id) )
		{
			return '';
		}
        $roles_arr = Roles::find('rid in (?)',Q::normalize($roles_id,","))->asArray()->getAll();
        foreach ($roles_arr as $value){
            $roles_idname[$value['rid']] = $value['rolename'];
        }
        //dump($roles_idname);

//        if ( in_array($sp_roles['REPEAL'],$roles_idname) ){
//            $return_value = array($value['rid'] => $sp_roles['REPEAL']);
//            return $return_value;
//        }elseif( in_array($sp_roles['FREEZE'],$roles_idname) ){
//            $return_value = array($value['rid'] => $sp_roles['FREEZE']);
//            return $return_value;
//        }elseif( in_array($sp_roles['UNCHECKED'],$roles_idname) ){
//            $return_value = array($value['rid'] => $sp_roles['UNCHECKED']);
//            return $return_value;
//        }else{
            return $roles_idname;
//        }
    }


    /* ******************************************************************** */
    /**
    * 获取用户的所有权限，并根据权限的状态进行分类
    * @param mixed $uid 要获取的用户的ID
    */
    function GetAllRoles( $uid = '' )
    {
        $show_box['title'] = '获取用户全部角色';
        $return_value = '';

        $user_roles =  UserHaveRoles::find('uid = ?',intval($uid) )->asArray()->getAll();

        foreach ($user_roles as $value){
            $role_info = Roles::find('rid = ?',$value['rid'])->query();
            if ($value['is_include']){
                $return_value['allow'][$value['rid']] = $role_info['rolename'];
            }else{
                $return_value['deny'][$value['rid']] = $role_info['rolename'];
            }
        }
        return $return_value['allow'];
    }

    
}