$(document).ready(function () {$("#submit-611739144").bind("click", function (event) {$.ajax({complete:function (XMLHttpRequest, textStatus) {$("#MessageAppForm").slideUp();}, data:$("#submit-611739144").closest("form").serialize(), dataType:"html", success:function (data, textStatus) {$("#Notification").html(data);}, type:"post", url:"\/cakephpblog\/messages"});
return false;});});