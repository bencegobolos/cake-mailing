$(document).ready(function () {$("#submit-1155170510").bind("click", function (event) {$.ajax({complete:function (XMLHttpRequest, textStatus) {$("#MessageAppForm").slideUp();}, data:$("#submit-1155170510").closest("form").serialize(), dataType:"html", success:function (data, textStatus) {$("#Notification").html(data);}, type:"post", url:"\/cakephpblog\/messages"});
return false;});});