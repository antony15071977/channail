<?php // Подключаемая автономная форма для использования на любом сайте.
//date_default_timezone_set('Europe/Moscow'); // часовой пояс
$ag_url = 'https://cms.agwd.ru/demo';  // Адрес Ag Booking CMS.
$ag_service_id = 'service_04_09_2017_06_37_26_93';  // ID услуги.
$ag_get_json = 'schedule';  // GET параметр JSON расписания (по умолчанию "schedule").
$ag_period = '120';  // Активный период календаря в количестве дней.
$ag_numerous_times = 1;  // 1 - Разрешить выбор нескольких единиц времени. 0 - Только одна.
$ag_closed_dates = '31.12,01.01,02.01,03.01';  // Недоступные даты через запятую (например: 31.12,01.01,02.01,03.01).
$ag_closed_week_days = '';  // Недоступные дни недели запятую. 0 - воскресение (например: 0,1,2).
$ag_pay_btn = 1;  // Кнопка "Перейти к оплате". 0 - Не показывать.
$ag_pay_imp = 0;  // 1 - Обязательная оплата.
$ag_policy_text = '
<h3>Политика конфиденциальности ("ПРИМЕР")</h3><p></p><p><strong>Персональная информация Пользователей, которая обрабатывается при заказе.</strong></p><p></p><p>Факт подачи заказа означает безоговорочное согласие Пользователя с настоящей Политикой и указанными в ней условиями обработки его персональной информации;  в случае несогласия с этими условиями Пользователь должен воздержаться от использования сервиса <strong>НАШ САЙТ</strong>. В рамках настоящей Политики под « персональной информацией Пользователя»  понимаются: Персональная информация, которую Пользователь предоставляет о себе самостоятельно при подачи заказа или в процессе использования сервиса <strong>НАШ САЙТ</strong>, включая персональные данные Пользователя. Персональная информация Пользователей не публикуется и не передаётся третьим лицам, за исключением случаев, где передача предусмотрена российским или иным применимым законодательством в рамках установленной законодательством процедуры. При обработке персональных данных Пользователей, сервис <strong>НАШ САЙТ</strong> руководствуется Федеральным законом РФ « О персональных данных» .</p><p></p><p><strong>2. Цели обработки персональной информации Пользователей.</strong></p><p></p><p>Адрес электронной почты, номер телефона используется сервисом <strong>НАШ САЙТ</strong> для связи с заказчиком (клиентом), а так же для подтверждения заказа и рассылки уведомлений о его статусе.</p><p></p><p><strong>3. Меры, применяемые для защиты персональной информации Пользователя.</strong></p><p></p><p><strong>НАШ САЙТ</strong> принимает необходимые и достаточные организационные и технические меры для защиты персональной информации Пользователя от неправомерного или случайного доступа, уничтожения, изменения, блокирования, копирования, распространения, а также от иных неправомерных действий с ней третьих лиц.</p><p></p>'; 
$ag_policy_title = 'Принимаю условия обработки персональных данных';  
$ag_page_title = 'Бронирование времени - Ag Booking CMS'; 
$ag_page_description = 'Демо услуга'; 
?>
<script>function ag_window_size_b(){ 
var ag_min_width=800; 
var ag_sizes={  }; 
var ag_win_width=window.innerWidth; 
var ag_win_height=$(window).outerHeight(true); ag_sizes={ minw:ag_min_width,windoww:ag_win_width,windowh:ag_win_height }; return ag_sizes;  }



function ag_responsitive_b(){ 
if (ag_window_size_b().windoww<ag_window_size_b().minw){ $("#ag_main_form_booking").addClass("ag_main_mobile"); 
$("#ag_main_form_booking").find(".ag_obj_item").css({ padding:"18px" }); 

 } else { 

$("#ag_main_form_booking").removeClass("ag_main_mobile"); 
$("#ag_main_form_booking").find(".ag_obj_item").css({ padding:"18px 0px" });  }

 }

function ag_pn(val){ 

if (val < 10){ val="0"+val;  }

 return val;  }


var ag_c_d = parseFloat(new Date().getDate()); 
var ag_c_m = parseFloat(new Date().getMonth()+1); 
var ag_c_y = parseFloat(new Date().getFullYear()); 
$(document).ready(function(){ $("#ag_date").val(ag_c_y+"-"+ag_pn(ag_c_m)+"-"+ag_pn(ag_c_d)); 
$("#ag_date_display").text(ag_pn(ag_c_d)+"."+ag_pn(ag_c_m)+"."+ag_c_y); ag_responsitive_b();  }); 

$(window).resize(function(){ ag_responsitive_b();  }); 
</script><div id="ag_main_form_booking"><div class="ag_obj_content ag_post_item"><div class="ag_obj_block ag_full_width_obj" style="margin:0 18px 18px 18px"><div class="ag_obj_item" style="padding:18px 0 18px 0"><div class="ag_obj_content ag_post_item ag_obj_inc"><h3 class="ag_title_obj ag_title_obj_open" style="padding:0 0 18px 0"><?php echo $ag_page_title;  ?></h3><div class="ag_obj_include"><div class="ag_obj_include_inner"><div class="ag_form_block" id="ag_onriv_form_block"><div id="ag_booking_form" class="ag_booking_form"><div id="ag_main_form" class="ag_main_form"><div class="ag_date"><label><span id="ag_date_display" tabindex="-1" onclick="ag_view_cal()" onfocus="ag_active(this)" onblur="ag_out(this)"><?php echo date("d.m.Y");  ?></span></label><input type="hidden" value="<?php echo date("Y-m-d");  ?>" id="ag_date" /><div class="ag_date_select" id="ag_date_select"><i class="ag_cal_arrow"></i><!-- <div class="ag_mob_table"> --><div class="ag_mob_table"><table id="ag_idate"><thead><tr class="ag_di_select_month"><td class="ag_di_ms" tabindex="-1"><i class="icon-left-open-big"></i></td>	<td colspan="5"></td><td tabindex="-1" class="ag_di_ms"><i class="icon-right-open-big"></i></td></tr><tr><td>Пн</td><td>Вт</td><td>Ср</td><td>Чт</td><td>Пт</td><td class="ag_holiday">Сб</td><td class="ag_holiday">Вс</td></tr></thead><tbody></tbody></table></div><!-- </div> // close tag added in ag_return_html function --></div></div><div class="ag_clear"></div><script>
var ag_closed_dates="<?php echo $ag_closed_dates;  ?>".split(","); 
var nowd="<?php echo $ag_closed_week_days;  ?>"; 
var no_week_day=[]; 

if (nowd){ no_week_day=nowd.split(",");  }



function ag_in_array_cal(value,array){ for(var i=0; i<array.length; i++){ 

if (value==array[i]) return true;  }

return false;  }



function ag_insert_date(e){ 
var idate=$(e).attr("data-day"); 
var imonth=$(e).attr("data-month"); 
var iyear=$(e).attr("data-year"); 
$("#ag_date").val(iyear+"-"+imonth+"-"+idate); 
$("#ag_date_display").html(idate+"."+imonth+"."+iyear); 
$(".ag_di").removeClass("ag_this_di"); 
$(e).addClass("ag_this_di"); ag_display_time(); setTimeout(function(){ ag_hidd_cal();  },50);  }



function ag_with_zerro(num){ 

if (num<10){ num="0"+num;  }

return num;  }



function ag_idate(id,year,month){ 
var selected_date=$("#ag_date").val(); 
var now=new Date(); 
var ag_thisDate=new Date(ag_c_y,ag_c_m-1,ag_c_d); 
var ag_endDate=new Date(ag_c_y,ag_c_m-1,ag_c_d+<?php echo $ag_period;  ?>); 
var Dlast=new Date(year,month+1,0).getDate(),D=new Date(year,month,Dlast),DNlast=new Date(D.getFullYear(),D.getMonth(),Dlast).getDay(),DNfirst=new Date(D.getFullYear(),D.getMonth(),1).getDay(),calendar='<tr>',month=["Январь","Февраль","Март","Апрель","Май","Июнь","Июль","Август","Сентябрь","Октябрь","Ноябрь","Декабрь"]; 

if (DNfirst !=0){ for(var i=1; i<DNfirst; i++) calendar+='<td></td>'; 

 } else { 

for(var i=0; i<6; i++) calendar+='<td></td>';  }

for(var i=1; i<=Dlast; i++){ 
var di=i; 

if (di<10){ di="0"+di;  }


var dw=new Date(D.getFullYear(),D.getMonth(),i).getDay(); 
var ag_checkDate=new Date(D.getFullYear(),D.getMonth(),i); 
var ag_today_class=""; 

if (i==new Date().getDate() && D.getFullYear()==new Date().getFullYear() && D.getMonth()==new Date().getMonth()){ ag_today_class=" ag_today";  }



if (ag_checkDate>=ag_thisDate && ag_checkDate<=ag_endDate){ 
var idate=di+"."+ag_with_zerro(D.getMonth()+1); 

if (ag_in_array_cal(idate,ag_closed_dates) || ag_in_array_cal(dw,no_week_day)){ calendar+='<td title="Дата закрыта">'+di+'</td>'; 

 } else { 


var selected_class=""; 
var check_select=D.getFullYear()+"-"+ag_with_zerro(D.getMonth()+1)+"-"+di; 

if (check_select==selected_date){ selected_class=" ag_this_di";  }

calendar+='<td tabindex="-1" class="ag_di'+ag_today_class+selected_class+'" data-day="'+di+'" data-month="'+ag_with_zerro(D.getMonth()+1)+'" data-year="'+D.getFullYear()+'" data-weekday="'+dw+'" onclick="ag_insert_date(this)">'+di+'</td>';  }



 } else { 

calendar+='<td>'+di+'</td>';  }



if (new Date(D.getFullYear(),D.getMonth(),i).getDay()==0){ calendar+='</tr>';  }

 }

if (DNlast>0){ for (var i=DNlast; i<7; i++){ calendar+='<td>  </td>';  }

 }$("#"+id+" tbody").html(calendar); 
$("#"+id+" thead tr.ag_di_select_month td:nth-child(2)").html(month[D.getMonth()]+" "+D.getFullYear()); 
$("#"+id+" thead tr.ag_di_select_month td:nth-child(2)").attr("data-month",D.getMonth()); 
$("#"+id+" thead tr.ag_di_select_month td:nth-child(2)").attr("data-year",D.getFullYear()); 

if ($("#"+id+" tbody tr").length<6){  } }ag_idate("ag_idate",new Date().getFullYear(),new Date().getMonth()); 
$("#ag_idate thead tr.ag_di_select_month:nth-child(1) td:nth-child(1)").click(function(){ ag_idate("ag_idate",$("#ag_idate thead tr.ag_di_select_month td:nth-child(2)").attr("data-year"),parseFloat($("#ag_idate thead td:nth-child(2)").attr("data-month"))-1);  }); 

$("#ag_idate thead tr.ag_di_select_month:nth-child(1) td:nth-child(3)").click(function(){ ag_idate("ag_idate",$("#ag_idate thead tr.ag_di_select_month td:nth-child(2)").attr("data-year"),parseFloat($("#ag_idate thead td:nth-child(2)").attr("data-month"))+1);  }); 
function ag_hidd_cal(){ $("#ag_date_select").fadeOut(120);  }

$(document).mouseup(function (e){ 
var ag_tcal=$(".ag_date"); 

if (!ag_tcal.is(e.target) && ag_tcal.has(e.target).length===0){ setTimeout(function(){ ag_hidd_cal();  },120);  }

 }); function ag_view_cal(){ 
var set_date=$("#ag_date").val().split("-"); 
var set_m=new Date().getMonth(); 
var set_y=new Date().getFullYear(); 

if (set_date[0]){ set_y=parseFloat(set_date[0]);  }



if (set_date[1]){ set_m=parseFloat(set_date[1])-1;  }

ag_idate("ag_idate",set_y,set_m); 
$("#ag_date_select").fadeIn(160);  }

</script><div id="ag_time_list" class="ag_time_list_select"><div class="ag_time_block">  </div></div><div class="ag_form"><label class="ag_first_name ag_important_input"><input type="text" value="" id="ag_first_name" placeholder="Имя*" onfocus="ag_active(this)" onblur="ag_out(this)" /></label><label class="ag_family_name"><input type="text" value="" id="ag_family_name" placeholder="Фамилия" onfocus="ag_active(this)" onblur="ag_out(this)" /></label><label class="ag_phone ag_important_input"><input type="text" value="" id="ag_phone" placeholder="Телефон*" onfocus="ag_active(this)" onblur="ag_out(this)" /></label><label class="ag_email ag_important_input"><input type="email" value="" id="ag_email" placeholder="E-mail*" onfocus="ag_active(this)" onblur="ag_out(this)" /></label><label class="ag_comment"><textarea id="ag_comment" placeholder="Комментарий" onfocus="ag_active(this)" onblur="ag_out(this)"></textarea></label><input type="hidden" value="" id="ag_source" /><input type="hidden" value="" id="ag_md5" /><input type="hidden" value="" id="ag_time" /><input type="hidden" value="" id="ag_spots" /><input type="hidden" value="" id="ag_price" /><input type="hidden" value="<?php echo $ag_service_id;  ?>" id="ag_your_slot_id" /><input type="hidden" value="" id="ag_check_spots" /><input type="hidden" value="00" id="ag_check_time_h" /><input type="hidden" value="00" id="ag_check_time_m" /><input type="hidden" value="00" id="ag_check_time_s" /><div class="ag_clear"></div><div class="ag_eula_input"><div class="ag_mob_table"><table class="ag_eula_block"><tr><td class="ag_eula_checkbox"><label class="ag_one_ceckbox" title="Принять"><input type="checkbox" value="1" id="ag_eula_accept" /><span class="ag_checkbox_custom"></span></label></td><td><div id="ag_eula_open" tabindex="-1" onclick="ag_eula('open')"><span><?php echo $ag_policy_title;  ?></span></div></td></tr></table></div><div class="ag_clear"></div></div><div id="ag_eula_text"><div class="inner"><div class="ag_eula_text_inner"><?php echo $ag_policy_text;  ?><div class="ag_clear"></div><span id="ag_eula_close" class="ag_button" tabindex="-1" onclick="ag_eula('close')"><i class="icon-cancel"></i> Закрыть</span><div class="ag_clear"></div></div></div></div></div><div class="ag_clear"></div><div id="ag_booking_submit"><button onclick="ag_submit_post()" class="ag_submit">Забронировать</button><div id="ag_view_time"></div></div><div class="ag_clear"></div><div class="ag_back_layer"></div><div id="ag_result"></div><div id="ag_total_price"><h3>Сумма: <span class="ag_summ"></span><span class="ag_curr"></span></h3></div><div class="ag_clear"></div></div></div></div><script>function ag_order_edit(){  }$("#ag_eula_text").css({ display:"none" }); function ag_eula(trig){ 

if (trig=="open"){ $(".ag_back_layer").fadeIn(250); 
$("#ag_eula_text").fadeIn(250);  }



if (trig=="close"){ $("#ag_eula_text").fadeOut(250); 
$(".ag_back_layer").fadeOut(250);  }

 }
var ag_move_hours=<?php echo date("H");  ?>; 
var ag_move_min=<?php echo date("i");  ?>; 
var ag_move_sec=<?php echo date("s");  ?>; function ag_check_time(){ 
var ag_move_sec_display=""; 
var ag_move_min_display=""; 
var ag_move_hour_display=""; 
var date=new Date(); 

if (ag_move_hours==date.getHours()){ ag_move_hours=date.getHours(); ag_move_min=date.getMinutes(); ag_move_sec=date.getSeconds(); 

 } else { 

ag_move_sec+=1; 

if (ag_move_sec>=60){ ag_move_min+=1; ag_move_sec=0;  }



if (ag_move_min>=60){ ag_move_hours+=1; ag_move_min=0;  }



if (ag_move_hours>=24){ ag_move_hours=0;  }

 }

if (ag_move_sec<10){ ag_move_sec_display="0"+ag_move_sec; 

 } else { 

ag_move_sec_display=ag_move_sec;  }



if (ag_move_min<10){ ag_move_min_display="0"+ag_move_min ; 

 } else { 

ag_move_min_display=ag_move_min;  }



if (ag_move_hours<10){ ag_move_hour_display="0"+ag_move_hours; 

 } else { 

ag_move_hour_display=ag_move_hours;  }

setTimeout("ag_check_time(); ",990); 
$("#ag_check_time_h").val(ag_move_hour_display); 
$("#ag_check_time_m").val(ag_move_min_display); 
$("#ag_check_time_s").val(ag_move_sec_display); 
$("#ag_view_time").html(ag_move_hour_display+":"+ag_move_min_display+":"+ag_move_sec_display);  }

ag_check_time(); function ag_count_price(){ 
var total=0; for (var tp=0; tp<$("#ag_time_list div.ag_time_block ul li.ag_selected").length; tp++){ 
var tprice=parseFloat($("#ag_time_list div.ag_time_block ul li.ag_selected").eq(tp).attr("data-price")); 
var spots_price=1; 

if ($("#ag_time_list div.ag_time_block ul li.ag_selected").eq(tp).find("input.ag_spots_order").val()){ spots_price=parseFloat($("#ag_time_list div.ag_time_block ul li.ag_selected").eq(tp).find("input.ag_spots_order").val());  }



if ($("#ag_time_list div.ag_time_block ul li.ag_selected").eq(tp).attr("data-cs")==1){ total+=(tprice*spots_price); 

 } else { 

total+=tprice;  }

 }

if (total>0){ total=total.toFixed(2); 
$("#ag_total_price h3 span.ag_summ").html(total); 
$("#ag_total_price").stop().animate({ left:"18px" },350,"easeInOutQuint"); 

 } else { 

$("#ag_total_price").stop().animate({ left:"-120%" },350,"easeInOutQuint");  }

 }

function ag_in_array_spot(value,array){ for(var i=0; i<array.length; i++){ 
var index=i+1; 

if (value==array[i]) return index;  }

return false;  }



function ag_spots_count(all_time){ 
var set_new_spots=""; 
var set_new_check_spots=""; 

if (!all_time){ all_time=$("#ag_time").val().split(",");  }



if (!$("#ag_time").val()){ $("#ag_check_spots").val(""); 
$("#ag_spots").val("");  }


var set_timea=[]; 
var set_spotsa=[]; for (var e=0; e<$(".ag_spots").length; e++){ 
var sdt=$(".ag_spots").eq(e).parents("li").attr("data-time"); 
var ssp=$(".ag_spots").eq(e).find("input.ag_spots_order").val(); set_timea[e]=sdt; set_spotsa[e]=ssp;  }

for (var t=0; t<all_time.length; t++){ 

if (ag_in_array_spot(all_time[t],set_timea)){ 
var is=ag_in_array_spot(all_time[t],set_timea); is=is-1; set_new_spots+=set_spotsa[is]+","; set_new_check_spots+=all_time[t]+"-"+set_spotsa[is]+",";  }

 }

if (set_new_spots !=""){ set_new_spots=set_new_spots.substring(0,set_new_spots.length-1); set_new_spots=set_new_spots.replace(new RegExp(",,",'g'),","); 
$("#ag_spots").val(set_new_spots);  }



if (set_new_check_spots !=""){ set_new_check_spots=set_new_check_spots.substring(0,set_new_check_spots.length-1); set_new_check_spots=set_new_check_spots.replace(new RegExp(",,",'g'),","); 
$("#ag_check_spots").val(set_new_check_spots);  }

 }

function ag_set_spots(){ 

if (!$("#ag_time").val()){ $("#ag_check_spots").val(""); 
$("#ag_spots").val("");  }

time_spots=$("#ag_check_spots").val().split(","); 
var ctimes=$("#ag_time").val(); 

if (!ctimes){ time_spots=[];  }

for (var ts=0; ts<time_spots.length; ts++){ 
var tsa=time_spots[ts].split("-"); 
var stime=tsa[0]; 
var sspot=tsa[1]; for (var ss=0; ss<$(".ag_spots").length; ss++){ 
var sdt=$(".ag_spots").eq(ss).parents("li").attr("data-time"); 

if (stime==sdt){ 

if ($(".ag_spots").eq(ss).find(".ag_this_spots")){ 
var stt=parseFloat($(".ag_spots").eq(ss).find(".ag_this_spots").val()); 
var os=parseFloat(sspot); 
var set_spots=stt-os; 

if (set_spots>=0){ $(".ag_spots").eq(ss).find("span.ag_spots_free span").text(set_spots); 
$(".ag_spots").eq(ss).find(".ag_spots_order").val(sspot);  }

 } } } } }

function ag_spots_check(inp){ 

if (inp){ 

if (this.ST) return; 
var ov=$(inp).val(); 
var ovrl=ov.replace(/\d*/,"").length; this.ST=true; 

if (ovrl>0){ $(inp).val($(inp).attr("lang")); ag_spots_checkError(inp); return }$(inp).attr("lang",$(inp).val()); this.ST=null; 
var time_spots=1; 

if ($(inp).parents(".ag_spots").find("span.ag_spots_free span").text()){ time_spots=parseFloat($(inp).parents(".ag_spots").find("span.ag_spots_free span").text());  }


var ag_this_spots=1; 

if ($(inp).siblings(".ag_this_spots").val()){ ag_this_spots=parseFloat($(inp).siblings(".ag_this_spots").val());  }


var inp_spots=0; 

if ($(inp).val()){ inp_spots=parseFloat($(inp).val());  }



if (inp_spots>0){ 
var time_spots_count=ag_this_spots-inp_spots; 

if (time_spots_count>=0){ $(inp).parents(".ag_spots").find("span.ag_spots_free span").text(time_spots_count);  }



 } else { 

$(inp).parents(".ag_spots").find("span.ag_spots_free span").text(ag_this_spots);  }



if (time_spots_count<0){ $(inp).val(1); ag_spots_checkError(inp); return }
var ag_spots_str=""; 
var ag_check_spots_str=""; 
var spots_data_time=$(inp).parents("li").attr("data-time"); 
var set_time=$("#ag_time").val().split(","); 
var set_spots=$("#ag_spots").val().split(","); for (var st=0; st<set_time.length; st++){ 
var sts=1; 

if (set_spots[st]){ sts=set_spots[st];  }



if (set_time[st]==spots_data_time){ sts=$(inp).val();  }

ag_spots_str+=sts+","; ag_check_spots_str+=set_time[st]+"-"+sts+",";  }



if (ag_spots_str !=""){ ag_spots_str=ag_spots_str.substring(0,ag_spots_str.length-1); ag_spots_str=ag_spots_str.replace(new RegExp(",,",'g'),","); 
$("#ag_spots").val(ag_spots_str);  }



if (ag_check_spots_str !=""){ ag_check_spots_str=ag_check_spots_str.substring(0,ag_check_spots_str.length-1); ag_check_spots_str=ag_check_spots_str.replace(new RegExp(",,",'g'),","); 
$("#ag_check_spots").val(ag_check_spots_str);  }

ag_count_price();  }

 }

function ag_spots_checkError(inp){ 

if (!this.inp){ this.inp=inp; 
$(inp).css({ background:"pink" }); this.TIM=setTimeout(ag_spots_checkError,100)

 } else { 

$(this.inp).parent().removeAttr("style"); 
$(this.inp).removeAttr("style"); clearTimeout(this.TIM); this.ST=null; ag_spots_check(inp); this.inp=null } }

function ag_spots_select(e,d){ 

if (!$(e).parents(".ag_spots").find(".ag_spots_order").val()){ $(e).parents(".ag_spots").find(".ag_spots_order").val("0");  }


var this_d=parseFloat($(e).parents(".ag_spots").find(".ag_spots_order").val()); 
var max_spots=parseFloat($(e).parents(".ag_spots").find(".ag_this_spots").val()); 
var left_sp=parseFloat($(e).parents(".ag_spots").find(".ag_spots_free span").text()); 
var set_d=this_d+d; 

if (set_d>=1 && set_d<=max_spots){ $(e).parents(".ag_spots").find(".ag_spots_order").val(set_d); ag_spots_check($(e).parents(".ag_spots").find("input.ag_spots_order"));  }



if (left_sp<0){ $(e).parents(".ag_spots").find(".ag_spots_order").val(1); 
$(e).parents(".ag_spots").find(".ag_spots_free span").text(max_spots-1);  }

 }
var ag_your_slot_id="<?php echo $ag_service_id;  ?>"; 

if ($("#ag_select_service").val()){ ag_your_slot_id=$("#ag_select_service").val();  }



function ag_height_times(){ 
var maxHeight=0; 
$(".ag_time_block ul li").find("p").height("auto").each(function (){ 

if ($(this).height()>maxHeight){ maxHeight=$(this).height();  }

 }).height(maxHeight);  }


var ag_count_display_time=0; 
function ag_display_time(){ 
var ag_selected_time=$("#ag_time").val().split(","); 
var ag_new_select_time=""; ag_count_display_time=ag_count_display_time+1; 
var ag_date=$("#ag_date").val(); 
var ag_time_list='<div class="ag_load_times"><i class="icon-spin1 animate-spin"></i></div>'; 
$("#ag_time_list div.ag_time_block").html(ag_time_list); 
$.getJSON("<?php echo $ag_url;  ?>/?<?php echo $ag_get_json;  ?>="+ag_your_slot_id+"",function(data){ 
var ag_currency = '';
var this_hour=parseFloat($("#ag_check_time_h").val()); 
var this_min=parseFloat($("#ag_check_time_m").val()); 
var count_time_p=0; ag_time_list='<ul>'; for (var i in data){ 
var ag_time_class=""; 

if (data[i].date==ag_date){ count_time_p++; for (var ti=0; ti<ag_selected_time.length; ti++){ 
var itimea=ag_selected_time[ti].split(":"); 
var ih=parseFloat(itimea[0]); 
var im=parseFloat(itimea[1]); 

if (ag_selected_time[ti]==data[i].time){ 

if (ag_date=="<?php echo date('Y-m-d');  ?>"){ 

if (ih>this_hour || ih==this_hour && im>this_min){ ag_time_class=" ag_selected"; ag_new_select_time+=data[i].time+",";  }



 } else { 



if (data[i].is_free !=false){ ag_time_class=" ag_selected"; ag_new_select_time+=data[i].time+",";  }

 } } }
var ag_spots=1; 

if (data[i].spots){ ag_spots=data[i].spots;  }


var ag_currency_val=data[i].currency; 
var ag_currency_sig=data[i].currency_sign; 
var ag_currency_pos=data[i].currency_position; 
var ag_display_price=data[i].price+" "+ag_currency_sig; 

ag_currency = ag_currency_sig;

if (ag_currency_pos=="1"){ ag_display_price=ag_currency_sig+" "+data[i].price;  }


var ag_dd=data[i].date.split("-"); 
var ag_display_date=ag_dd[2]+"."+ag_dd[1]+"."+ag_dd[0]; 
var ag_display_time=data[i].time+"  -  "+data[i].time_end; 

if (data[i].time_end=="XX:XX"){ ag_display_time=data[i].time;  }



if (data[i].is_free==false){ ag_time_list+='<li class="ag_disabled"><p>'+ag_display_time+'<span class="ag_currency">'+ag_display_price+'</span></p></li>'; 

 } else { 

ag_time_list+='<li class="ag_enabled'+ag_time_class+'" tabindex="-1"'; ag_time_list+=" onclick=\"ag_select_time('"+data[i].time+"',this)\" "; ag_time_list+='data-time="'+data[i].time+'" data-price="'+data[i].price+'" data-cs="'+data[i].count_spots+'"><p>'+ag_display_time+'<span class="ag_currency">'+ag_display_price+'</span>'; 

if (ag_spots>1){ ag_time_list+='<span class="ag_spots">'; ag_time_list+='<span class="ag_spots_input"><input type="text" value="" placeholder="Кол-во мест" oninput="ag_spots_check(this)" onpropertychange="ag_spots_check(this)" class="ag_spots_order"/><input type="hidden" value="'+ag_spots+'" class="ag_this_spots"/><span class="ag_spots_select ag_spots_select_plus" tabindex="-1" onclick="ag_spots_select(this,1)"><i class="icon-up-dir"></i></span><span class="ag_spots_select ag_spots_select_minus" tabindex="-1" onclick="ag_spots_select(this,-1)"><i class="icon-down-dir-1"></i></span></span>'; ag_time_list+='<span class="ag_spots_free">Свободно:  <span>'+ag_spots+'</span></span>'; ag_time_list+='</span>'; 

 } else { 

ag_time_list+='<span class="ag_spots ag_hidden"><input type="hidden" value="1" class="ag_spots_order"/><input type="hidden" value="0" class="ag_this_spots"/></span>';  }

ag_time_list+='</p></li>';  }

 } }

if (count_time_p>6){ $("#ag_booking_form").addClass("ag_top_times"); 

 } else { 

$("#ag_booking_form").removeClass("ag_top_times");  }

ag_new_select_time=ag_new_select_time.substring(0,ag_new_select_time.length-1); ag_new_select_time=ag_new_select_time.replace(new RegExp(",,",'g'),","); ag_new_select_time=ag_new_select_time.replace(new RegExp(" ",'g'),""); 
$("#ag_time").val(ag_new_select_time); 

if (ag_time_list=='<ul>'){ ag_time_list+='<li class="ag_no_time"><p>Нет доступного времени</p></li>';  }

ag_time_list+='<li class="ag_clear"></li></ul>'; 
$("#ag_time_list div.ag_time_block").html(ag_time_list); ag_set_spots(); ag_select_time(0,0); ag_spots_count(ag_new_select_time.split(",")); ag_height_times(); ag_count_price(); setTimeout(function(){ ag_order_edit();  },70);  

$("span.ag_curr").html(ag_currency);

}).fail(function(jqXHR,textStatus,errorThrown){ ag_time_list='<ul><li class="ag_no_time"><p>Нет ответа ('+textStatus+')</p></li></ul>'; 
$("#ag_time_list div.ag_time_block").html(ag_time_list);  }); 


if (ag_count_display_time>1){ 
var ag_margin_top=$("#ag_mob_top_panel").outerHeight(true)+18; 
$("html,body").stop().animate({ scrollTop:$("#ag_onriv_form_block").offset().top-ag_margin_top },400,"easeOutQuart");  }

 }setInterval("ag_count_display_time=0; ag_display_time(); ",300000); function ag_select_service(e){ $("#ag_title_servie").text($(e).find("option:selected").text()); window.location="";  }

<?php 
if ($ag_numerous_times == 1) {  ?>function ag_select_time(time,e){ $("input.ag_spots_order,span.ag_spots_select").click(function(){ 

if (($(this).parents("li").attr("class").indexOf("ag_selected")+1)>0){ return false;  }

 }); 
var stime=""; 
var itime=""; 

if (time){ 

if ($("#ag_time").val()){ stime=$("#ag_time").val()+",";  }



if ((stime.indexOf(time)+1)>0){ 
var stimea=stime.split(","); 
var this_hour=parseFloat($("#ag_check_time_h").val()); 
var this_min=parseFloat($("#ag_check_time_m").val()); for (var ti=0; ti<stimea.length; ti++){ 

if (stimea[ti] !=time && stimea[ti] !=""){ 
var ctime=""; 
var itimea=stimea[ti].split(":"); 
var ih=parseFloat(itimea[0]); 
var im=parseFloat(itimea[1]); 

if ($("#ag_date").val()=="<?php echo date('Y-m-d');  ?>"){ 

if (ih>this_hour || ih==this_hour && im>this_min){ ctime=stimea[ti];  }



 } else { 

ctime=stimea[ti];  }

itime+=ctime+",";  }

 }itime=itime.substring(0,itime.length-1); 
$(e).removeClass("ag_selected"); 

if ($(e).find("input.ag_spots_order").val()){ $(e).find("input.ag_spots_order").val("");  }



 } else { 

itime=stime+time; 
$(e).addClass("ag_selected"); 

if (!$(e).find("input.ag_spots_order").val()){ $(e).find("input.ag_spots_order").val("1");  }

 }itime=itime.replace(new RegExp(",,",'g'),","); itime=itime.replace(new RegExp(" ",'g'),""); 
$("#ag_time").val(itime); ag_spots_check($(e).find("input.ag_spots_order")); ag_spots_count(itime.split(",")); ag_count_price();  }

 }<?php  } else {  ?>function ag_select_time(time,e){ 

if ($(e).attr("class")=="ag_enabled ag_selected"){ $(".ag_enabled").removeClass("ag_selected"); 
$("input.ag_spots_order").val(""); 
$("#ag_time").val(""); 
$("#ag_spots").val(""); ag_count_price(); return false;  }

$("span.ag_spots").each(function(){ 
var val_cs=$(this).find(".ag_spots_input").val(); 
var val_ls=$(this).find(".ag_this_spots").val(); 
$(this).find(".ag_spots_free span").text(val_ls);  }); 

$(e).find("input.ag_spots_order,span.ag_spots_select").click(function(){ 

if (($(this).parents("li").attr("class").indexOf("ag_selected")+1)>0){ return false;  }

 }); 

if (time){ $(".ag_enabled").removeClass("ag_selected"); 
$("input.ag_spots_order").val(""); 
$(e).find("input.ag_spots_order").val("1"); 
var this_hour=parseFloat($("#ag_check_time_h").val()); 
var this_min=parseFloat($("#ag_check_time_m").val()); 
var itimea=time.split(":"); 
var ih=parseFloat(itimea[0]); 
var im=parseFloat(itimea[1]); 

if ($("#ag_date").val()=="<?php echo date('Y-m-d');  ?>"){ 

if (ih>this_hour || ih==this_hour && im>this_min){ $("#ag_time").val(time); 
$(e).addClass("ag_selected");  }



 } else { 

$("#ag_time").val(time); 
$(e).addClass("ag_selected");  }

ag_spots_check($(e).find("input.ag_spots_order")); ag_spots_count(time.split(",")); ag_count_price();  }

 }<?php  } ?>function ag_insert_date(e){ 
var idate=$(e).attr("data-day"); 
var imonth=$(e).attr("data-month"); 
var iyear=$(e).attr("data-year"); 
$("#ag_date").val(iyear+'-'+imonth+'-'+idate); 
$("#ag_date_display").html(idate+'.'+imonth+'.'+iyear); 
$(".ag_di").removeClass("ag_this_di"); 
$(e).addClass("ag_this_di"); ag_display_time(); setTimeout(function(){ ag_hidd_cal();  },70);  }

ag_display_time(); 
$(window).on("resize",function (){ ag_height_times();  }); 
function ag_wait_post(i){ 
var button_w=$("#ag_booking_submit").find("button").outerWidth(true); 
var button_h=$("#ag_booking_submit").find("button").outerHeight(true); 

if (i==1){ $("#ag_booking_submit").find("button").addClass("ag_wait_post"); 
$("#ag_booking_submit").find("button").css({ minWidth:button_w+"px" }); 
$("#ag_booking_submit").find("button").removeAttr("onclick"); 
$("#ag_booking_submit").find("button").html('<i class="icon-spin1 animate-spin"></i>'); 

 } else { 

$("#ag_booking_submit").find("button").stop().animate({ opacity:"0" },200); setTimeout(function(){ $("#ag_booking_submit").find("button").html(""); 
$("#ag_booking_submit").find("button").text("Забронировать"); 
$("#ag_booking_submit").find("button").css({ minWidth:"auto" }); 
$("#ag_booking_submit").find("button").removeClass("ag_wait_post"); 
$("#ag_booking_submit").find("button").attr("onclick","ag_submit_post()"); 
$("#ag_booking_submit").find("button").stop().animate({ opacity:"1" },200);  },300);  }

 }

function ag_submit_post(){ 

if ($("#ag_eula_accept").prop("checked")){ 

 } else { 

$(".ag_back_layer").fadeIn(250); 
$("#ag_result").css({ top:"-100%",display:"block" }); ag_inner_class=""; 
var ag_min_width=800; 
var ag_win_width=window.innerWidth; 
var ag_win_height=$(window).outerHeight(true); 

if (ag_win_width<ag_min_width){ ag_inner_class=" inner_mobile"; 
$("#ag_result").stop().animate({ top:"0px" },400); 

 } else { 

ag_inner_class=""; 
$("#ag_result").stop().animate({ top:"20%" },400);  }


var ag_dialog_class=" ag_error"; 
$("#ag_result").html('<div class="inner'+ag_inner_class+''+ag_dialog_class+'"><p><strong>Ошибка</strong></p><p>Не заполнены (не отмечены) обязательные поля:</p><p>Принимаю условия обработки персональных данных</p><span class="ag_button" onclick="ag_close_done()">Закрыть</span><div class="ag_clear"></div></div>'); return false;  }


var ag_first_name=$("#ag_first_name").val(); 
var ag_family_name=$("#ag_family_name").val(); 
var ag_phone=$("#ag_phone").val(); 
var ag_email=$("#ag_email").val(); 
var ag_comment=$("#ag_comment").val(); 
var ag_source=$("#ag_source").val(); 
var ag_md5=$("#ag_md5").val(); 
var ag_date=$("#ag_date").val(); 
var ag_time=$("#ag_time").val(); 
var ag_spots=$("#ag_spots").val(); 
var ag_price=$("#ag_price").val(); 
var ag_your_slot_id=$("#ag_your_slot_id").val(); 
$.ajax({ type:"POST",url:"<?php echo $ag_url;  ?>/?<?php echo $ag_get_json;  ?>=<?php echo $ag_service_id;  ?>",data:"first_name="+ag_first_name+"&family_name="+ag_family_name+"&phone="+ag_phone+"&email="+ag_email+"&comment="+ag_comment+"&source="+ag_source+"&md5="+ag_md5+"&date="+ag_date+"&time="+ag_time+"&spots="+ag_spots+"&price="+ag_price+"&your_slot_id="+ag_your_slot_id+"",success:function(data){ 
var ag_dialog_class=" ag_message"; 
var ddatea=ag_date.split("-"); 
var ddate=ddatea[2]+"."+ddatea[1]+"."+ddatea[0]; 
var ag_time_disp=ag_time; 

if (ag_time){ ag_time_disp=ag_time.replace(new RegExp(",",'g'),"‚   ");  }



if (!data.message && data.success !=false){ data.message='<p><strong>Заказ принят</strong></p><p>Время:  <strong>'+ag_time_disp+'</strong>  на  <strong>'+ddate+'</strong></p>'; ag_dialog_class=" ag_done"; 
$("#ag_time").val("");  }



if (data.success==false){ ag_dialog_class=" ag_error";  }



if (!data.message && !data.success){ ag_dialog_class=" ag_error"; data.message="<p>Нет ответа</p>";  }

$(".ag_back_layer").fadeIn(250); 
$("#ag_result").css({ top:"-100%",display:"block" }); ag_inner_class=""; 
var ag_min_width=800; 
var ag_win_width=window.innerWidth; 
var ag_win_height=$(window).outerHeight(true); 

if (ag_win_width<ag_min_width){ ag_inner_class=" inner_mobile"; 
$("#ag_result").stop().animate({ top:"0px" },400); 

 } else { 

ag_inner_class=""; 
$("#ag_result").stop().animate({ top:"20%" },400);  }


var ag_cifrm_order=""; 

if (ag_dialog_class==" ag_done"){ ag_cifrm_order="; ag_close_edit_order()";  }


var ag_result_disp=""; ag_result_disp='<div class="inner'+ag_inner_class+''+ag_dialog_class+'"><div class="ag_answer_booking">'+data.message+'</div>'; 
var ag_pay_btn=<?php echo $ag_pay_btn;  ?>; 

if (data.success !=false && ag_pay_btn == 1){ ag_result_disp+='<span class="ag_button ag_pay_button" onclick="ag_pay('+data.success+'); ">Перейти к оплате заказа</span>';  }


var pay_methods_imp=0; pay_methods_imp=<?php echo $ag_pay_imp;  ?>; 

if (pay_methods_imp==0 || data.success==false){ ag_result_disp+='<span class="ag_button" onclick="ag_close_done()'+ag_cifrm_order+'">Закрыть</span><div class="ag_clear"></div></div>';  }

$("#ag_result").html(ag_result_disp);  },error:function(XMLHttpRequest,textStatus,errorThrown){ $(".ag_back_layer").fadeIn(250); 
$("#ag_result").css({ top:"-100%",display:"block" }); ag_inner_class=""; 
var ag_min_width=800; 
var ag_win_width=window.innerWidth; 
var ag_win_height=$(window).outerHeight(true); 

if (ag_win_width<ag_min_width){ ag_inner_class=" inner_mobile"; 
$("#ag_result").stop().animate({ top:"0px" },400); 

 } else { 

ag_inner_class=""; 
$("#ag_result").stop().animate({ top:"20%" },400);  }

ag_dialog_class=" ag_error"; 
$("#ag_result").html('<div class="inner'+ag_inner_class+''+ag_dialog_class+'"><div class="ag_answer_booking">Нет ответа</div><span class="ag_button" onclick="ag_close_done()">Закрыть</span><div class="ag_clear"></div></div>');  }

 }); ag_wait_post(1);  }



function ag_pay(num){ window.location="<?php echo $ag_url;  ?>/?confirm="+num+"&pay";  }



function ag_close_done(){ $(".ag_back_layer").fadeOut(250); 
$("#ag_result").stop().animate({ top:"-100%" },300); ag_display_time(); ag_wait_post(0);  }



function ag_close_edit_order(){  }

function ag_active(elem){ $(elem).parent().addClass("ag_active");  }



function ag_out(elem){ $(elem).parent().removeClass("ag_active");  }

</script></div></div></div></div></div></div></div>