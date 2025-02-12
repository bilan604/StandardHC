<?php

class Helper_Common
{
	static public function ValidEmail($email, $strict=false) {
		$regexp = '/^[\w\-\.]+@[\w\-]+(\.[\w\-]+)*(\.[a-z]{2,})$/';
		if ( preg_match($regexp, $email) ){
			if (strstr(strtoupper(PHP_OS),'WIN')) {
				return true;
			}
			list ($user,$domain) = explode('@', $email, 2);
			if ( $strict && !gethostbyname($domain) 
					&& !getmxrr($domain,$mxhosts) ){
				return false;
			}
			return true;
		}
		return false;
	}
	//
	static public function UUID( $prefix='', $suffix_len = 3 )
	{
/*		$time = explode(' ', microtime());
        $id = ($time[1] - $being_timestamp) . sprintf('%06u', substr($time[0], 2, 6));
        if ($suffix_len > 0)
        {
            $id .= substr(sprintf('%010u', mt_rand()), 0, $suffix_len);
        }*/
		
		$id = uniqid($prefix);
		if ($suffix_len > 0)
        {
            $id .= substr(sprintf('%010u', mt_rand()), 0, $suffix_len);
        }
		
        return $id;
	}
	
	static public function SEOSmartLink( $output )
	{
		//查找词替换
		$life_time = 3600 * 24;
		if (!($words = Q::cache('page.innerlink.words') ) )
		{
			QLog::log('write cache: page.innerlink.words', QLog::DEBUG);
			$words = Innerlink::find()->asArray()->getAll();
			Q::writeCache('page.innerlink.words' ,$words,array('life_time'=>$life_time));
		}
		
		//mb_regex_encoding('gb2312');
		foreach($words as $word)
		{
			$output = mb_ereg_replace("(".$word['word'].")","<a href='".$word['linkurl']."'>\\1</a>",$output);
			//$output = preg_replace("/[^>](".$word['word'].")[^<]/i","<a href='".$word['linkurl']."'>$1</a>",$output);
		}
		
		return $output;
	}

}