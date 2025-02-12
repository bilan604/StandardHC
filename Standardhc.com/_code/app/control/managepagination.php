<?php

class Control_Managepagination extends QUI_Control_Abstract
{
    function render()
    {
        $pagination = $this->pagination;
        $udi        = $this->get('udi', $this->_context->requestUDI());
        $length     = $this->get('length', 9);
        $slider     = $this->get('slider', 2);
		$first_label= $this->get('first_label',"First");
		$last_label = $this->get('last_label',"Last");
        $prev_label = $this->get('prev_label', '上一页');
        $next_label = $this->get('next_label', '下一页');
        $url_args   = $this->get('url_args');
		$show_first = $this->get('show_first',false);
		$show_last  = $this->get('show_last',false);
		$show_go    = $this->get('show_go',false);

		$url_args = (array)$url_args;
		$url_args['page'] = '000000';
		$url = url($udi,$url_args);
		$out = '';
		if ($show_go)
		{
			$out .= "<script type=\"text/javascript\">function url_redirect(){var url='{$url}';var page=$('#paginator_page').val();document.location.href=url.replace('000000',page);}</script>";
		}
        $out .= "<div class=\"paginator\">\n";

        //$out .= '<ul id="' . h($this->id()) . "\">\n";
		
		$url_args['page'] = 1;
		
		if ($show_first)
		{
			$url = url($udi,$url_args);
			$out.="<a href=\"{$url}\">{$first_label}</a>\n ";
		}
		
        if ($pagination['current'] == $pagination['first'])
        {
            $out .= "<a href=\"javascript:;\" class=\"prev-label\">{$prev_label}</a>\n";
        }
        else
        {
            $url_args['page'] = $pagination['prev'];
            $url = url($udi, $url_args);
            $out .= "<a href=\"{$url}\" class=\"prev-label\">{$prev_label}</a>\n";
        }

        $base = $pagination['first'];
        $current = $pagination['current'];

        $mid = intval($length / 2);
        if ($current < $pagination['first'])
        {
            $current = $pagination['first'];
        }
        if ($current > $pagination['last'])
        {
            $current = $pagination['last'];
        }

        $begin = $current - $mid;
        if ($begin < $pagination['first'])
        {
            $begin = $pagination['first'];
        }
        $end = $begin + $length - 1;
        if ($end >= $pagination['last'])
        {
            $end = $pagination['last'];
            $begin = $end - $length + 1;
            if ($begin < $pagination['first'])
            {
                $begin = $pagination['first'];
            }
        }

        if ($begin > $pagination['first'])
        {
            for ($i = $pagination['first']; $i < $pagination['first'] + $slider && $i < $begin; $i ++)
            {
                $url_args['page'] = $i;
                $in = $i + 1 - $base;
                $url = url($udi, $url_args);
                $out .= "<a href=\"{$url}\">{$in}</a>\n";
            }

            if ($i < $begin)
            {
                $out .= "...\n";
            }
        }

        for ($i = $begin; $i <= $end; $i ++)
        {
            $url_args['page'] = $i;
            $in = $i + 1 - $base;
            if ($i == $pagination['current'])
            {
                $out .= "<span class=\"this-page\">{$in}</span>\n";
            }
            else
            {
                $url = url($udi, $url_args);
                $out .= "<span class=\"next-page\"><a href=\"{$url}\">{$in}</a></span>\n";
            }
        }

        if ($pagination['last'] - $end > $slider)
        {
            $out .= "...\n";
            $end = $pagination['last'] - $slider;
        }

        for ($i = $end + 1; $i <= $pagination['last']; $i ++)
        {
            $url_args['page'] = $i;
            $in = $i + 1 - $base;
            $url = url($udi, $url_args);
            $out .= "<a href=\"{$url}\">{$in}</a>\n";
        }

        if ($pagination['current'] == $pagination['last'])
        {
            $out .= "<a href=\"javascript:;\" class=\"next-label\">{$next_label}</a>\n";
        }
        else
        {
            $url_args['page'] = $pagination['next'];
            $url = url($udi, $url_args);
            $out .= "<a href=\"{$url}\" class=\"next-label\">{$next_label}</a>\n";
        }
		
		$url_args['page'] = $pagination['last'];
		$url = url($udi,$url_args);
		
		if ($show_last)
		{
			$out.="<a href=\"{$url}\" >{$last_label}</a>\n ";
		}
		
		 if ($this->get('show_count'))
        {
            $out .= "Total: {$pagination['record_count']} items\n";
        }
		
		if ($show_go)
		{
			$out .="<span><input type='text' name='page' id='paginator_page' style='height:14px;width:16px;' /> <input type='button' value='GO' onclick='url_redirect()' style='height:22px;width:26px;' /></span>";
		}
		
        $out .= "</div>\n";
		

        return $out;
    }
}
