$( "#radio" ).buttonset();

$('#update_options').click(function()
{
var exam_id =$('#exam_id').val();		
var ques_id =$('#option_id').val();	
var ques_title = $('#inputTitle').val();
var option_id1 =$('#option_id1').val();
var option_id2 =$('#option_id2').val();
var option_id3 =$('#option_id3').val();
var option_id4 =$('#option_id4').val();

var options1 = $('#options1').val();
var options2 = $('#options2').val();
var options3 = $('#options3').val();
var options4 = $('#options4').val();

var answer = $('#answer').val();	

$.post('exam_update_add_question.php',{exam_id:exam_id,answer:answer,ques_id:ques_id,ques_title:ques_title,
	option_id1:option_id1,options1:options1,option_id2:option_id2,options2:options2,option_id3:option_id3,
	options3:options3,option_id4:option_id4,options4:options4}, function()
	{
	$('#control-group1').hide();
	$('#settings').text('sdf');
	$('#options1').hide();
	$('#options2').hide();
	$('#options3').hide();
	$('#options4').hide();
	$('#answer').hide();
	$('#a').hide();
	$('#ab').hide();
	$('#b').hide();
	$('#c').hide();
	$('#d').hide();
	$('#e').hide();
	$('#update_options').hide();
	$('#head').fadeIn(1200);
	});
});