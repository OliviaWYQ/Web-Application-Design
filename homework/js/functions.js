// JavaScript Document

    //根据传入的checkbox的选中状态设置所有checkbox的选中状态
	//调用时 <input id="chk_SelectALL" type="checkbox" onclick="selectAll(this)" />全选
function selectAll(obj)
  {
        var allInput = document.getElementsByTagName("input");
        //alert(allInput.length);
        var loopTime = allInput.length;
        for(i = 0;i < loopTime;i++)
        {
            //alert(allInput[i].type);
            if(allInput[i].type == "checkbox")
            {			
                allInput[i].checked = obj.checked;
            }
        }
  }

function confirmAct() //onclick="return confirmAct();"
{ 
    if(confirm('确定要执行此操作吗?')) 
    { 
        return true; 
    } 
    return false; 
} 
