$(document).ready(function () {$("#submit-418814781").bind("click", function (event) {$.ajax({complete:function (XMLHttpRequest, textStatus) {$("#MessageAppForm").slideUp();}, data:$("#submit-418814781").closest("form").serialize(), dataType:"html", success:function (data, textStatus) {$("#Notification").html(data);}, type:"post", url:"\/cakephpblog\/messages"});
return false;});});