<?php
class page
{
	var $page_string="";  //返回的链接
	var $from="";         //当前行数 就是数据库查询偏移量
	var $total="";        //记录总数
	var $pagesize="";      //每页行数
	var $page_name="";    //参数名
	function __construct($total,$pagesize="10",$page_name,$page="1")
	{	
		
		$this->total=$total;
		$this->pagesize=$pagesize;
		$this->page_name=$page_name;
		$this->page=$page;
    }
	
	function getPagesize()
	{
		return $this->pagesize;
		
    }
	
   function getOffset()
   {
	if(intval($this->total%$this->pagesize)==0)
      {
   	  $totalpage=intval($this->total/$this->pagesize);
      }
   else if(intval($this->total%$this->pagesize)>0)
     {
   	  $totalpage=intval($this->total/$this->pagesize+1);
     }
   else if($this->total<$this->pagesize)
    {
   	 $totalpage=0;
     }
  if($this->page == 1 )
    {
   $this->page_string .= '第一页|上一页|';
    }
  else
    {
   $this->page_string .= '<a href=?'.$this->page_name.'=1>第一页</a>|<a href=?'.$this->page_name.'='.($this->page-1).'>上一页</a>|';
    }
 if( ($this->page == $totalpage) || ($totalpage == 0) )
   {
   $this->page_string .= '下一页|尾页';
   }
 else
   {
   $this->page_string .= '<a href=?'.$this->page_name.'='.($this->page+1).'>下一页</a>|<a href=?'.$this->page_name.'='.$totalpage.'>尾页</a>';
   }

   $this->from=($this->page-1)*$this->pagesize;
   return $this->from;
}
  function show()
  {
	  echo $this->page_string;
  }
}

?>