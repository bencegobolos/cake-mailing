$(document).ready(function () {$("#submit-1706098263").bind("click", function (event) {$.ajax({complete:function (XMLHttpRequest, textStatus) {$("#MessageAppForm").slideUp();}, data:$("#submit-1706098263").closest("form").serialize(), dataType:"html", success:function (data, textStatus) {$("#Notification").html(data);}, type:"post", url:"\/cakephpblog\/messages"});
return false;});});