<style>
    .fv-plugins-message-container {
        position: absolute;
    }
    .erp_form___block {
        position: relative;
    }
    .table-scroll {
        position: relative;
        width: 100%;
        overflow: auto;
        max-height: 488px;
        border-top: 2px solid #d5d5d5 !important;
    }
    table.egt_form_table thead.egt_form_header tr th{
        position: -webkit-sticky;
        position: sticky;
        top: -1px;
        background-color: #f9f9f9;
        font-size: 11px;
        font-weight: 500 !important;
        text-align: center;
        border-right: 1px solid #ebedf2;
        z-index: 3;
        padding: 5px;
    }
    table.egt_form_table thead.egt_form_header tr td{
        position: -webkit-sticky;
        position: sticky;
        top: 27px;
        background-color: #f9f9f9;
        font-size: 11px;
        font-weight: 500 !important;
        text-align: center;
        border-right: 1px solid #ebedf2;
        z-index: 3;
        padding: 0 !important;
    }
    tbody.egt_form_body>tr>td {
        padding: 0;
    }
    table.egt_form_table select ,
    table.egt_form_table input {
        border: 0;
    }
    table.egt_form_table .egt_form_header_input input:read-only,
    table.egt_form_table .egt_form_body input:read-only,
    table.egt_form_table .egt_form_footer input:read-only{
        background-color: #f7f7f7 !important;
    }
    table.egt_form_table .egt_form_body tr>td:first-child.handle>i{
        position: absolute;
        background: #7c7c7c;
        color: #fff;
        padding: 7px;
        border: 1px solid #7c7c7c;
        cursor: all-scroll;
    }
    input[data-id="egt_sr_no"] {
        margin-left: 25px;
        width: calc(100% - 25px);
    }

    /*==========================
start checkbox
*/
    .colToggleMenu li label {
        display: block;
        padding: 3px 10px;
        clear: both;
        font-weight: normal;
        line-height: 1.42857143;
        color: #333;
        white-space: nowrap;
        margin:0;
        transition: background-color .4s ease;
    }
    .colToggleMenu li input {
        margin: 0 5px;
        top: 2px;
        position: relative;
    }

    .colToggleMenu li.active label {
        background-color: #f5f5f5;
    }

    .colToggleMenu li label:hover,
    .colToggleMenu li label:focus {
        background-color: #f5f5f5;
    }

    .colToggleMenu li.active label:hover,
    .colToggleMenu li.active label:focus {
        background-color: #f5f5f5;
    }
    /*
        end checkbox
    ==================================== */

    /*
scrollbar styling
*/
    .table-scroll::-webkit-scrollbar-track
    {
        -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3);
        background-color: #ffffff;
        border-radius: 10px;

    }
    .table-scroll::-webkit-scrollbar
    {
        width: 10px;
        height: 10px;
        background-color: #ffffff;
    }
    .table-scroll::-webkit-scrollbar-thumb
    {
        background-color: #7f7f7f;
    }
    .table-scroll:hover,
    .table-scroll:focus {
        visibility: visible;
    }
    .table-scroll {
        position: relative;
        width:100%;
        overflow: auto;
        max-height: 488px;
        border-top: 2px solid #d5d5d5 !important;
    }
    /* table and table-head*/


    table.egt_form_table thead>tr>th:last-child,
    table.egt_form_table thead>tr>td:last-child{
        position: sticky;
        right: -8px;
        z-index: 5;
        background: #ddd;
    }
    table.egt_form_table tbody>tr>td:last-child,
    table.egt_form_table tfoot>tr>td:last-child{
        position: sticky;
        right: -8px;
        z-index: 0;
        background: #ddd;
    }

    .egt_handle{
        width: 13px;
        height: 25px;
        color: #929292;
        padding: 7px 0 0 5px;
        float: left;
        cursor: move;
    }
    .egt_form_footer {
        background: #fff8f8;
    }
</style>
<script>
    var giveTableWidth = 0; var colWidth = []; var colHide = [];
    var thLength = $('.egt_form_header>tr>th').length;
    if(colWidth.length != thLength){
        colWidth = [];
        var tableWidth = $('.table-scroll').width();
        tableWidth = tableWidth - 45;
        var eqWidth = parseInt(tableWidth)/parseInt(thLength-1);
        for (var o=0;o<thLength;o++){
            if(o == (thLength-1)){
                eqWidth = 45;
            }
            colWidth.push(eqWidth);
        }
    }
    console.log(colWidth);
    //   var colWidth = [86,120,120,100,50,100,100,100,100,120,110,100,100,100,120,50];
    //   var colHide = [6,7];
    $('#pageUserSettingSaveNONE').click(function(){
        var colWidth = "";
        $('.egt_form_header>tr>th').each(function(index){
            var thix = $(this)
            colWidth += (parseInt(thix.width())) + ","
        })
        var n = colWidth.lastIndexOf(",");
        var colWidth = colWidth.substring(0,n)

        var colHide = "";
        $('ul.listing_dropdown>li').each(function(index){
            var thix = $(this)
            var inputChecked = thix.find('label>input');

            if (!inputChecked.is(":checked"))  {
                colHide += index + ","
            }
        })
        var nn = colHide.lastIndexOf(",");
        var colHide = colHide.substring(0,nn)
        var formData = {
            document_type : '{{isset($form_type)?$form_type:""}}',
            colWidth : colWidth,
            colHide : colHide
        }
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type        : 'POST',
            url         : '/common/user-page-setting', //GetAllData userPageSetting
            dataType	: 'json',
            data        : formData,
            success: function(response) {
                if(response.status == 'success'){
                    toastr.success(response.message);
                }
            }
        });
    });

    function table_th_resize(){
        // colResizable 1.6 - a jQuery plugin by Alvaro Prieto Lauroba http://www.bacubacu.com/colresizable/
        !function(t){var e,i=t(document),r=t("head"),o=null,s={},d=0,n="id",a="px",l="JColResizer",c="JCLRFlex",h=parseInt,f=Math,p=navigator.userAgent.indexOf("Trident/4.0")>0;try{e=sessionStorage}catch(t){}r.append("<style type='text/css'>  .JColResizer{table-layout:fixed;} .JColResizer > tbody > tr > td, .JColResizer > tbody > tr > th{overflow:hidden;/*padding-left:0!important; padding-right:0!important;*/}  .JCLRgrips{ height:0px; position:relative;} .JCLRgrip{margin-left:-5px; position:absolute; z-index:5; } .JCLRgrip .JColResizer{position:absolute;background-color:red;filter:alpha(opacity=1);opacity:0;width:10px;height:100%;cursor: e-resize;/*top:0px*/} .JCLRLastGrip{position:absolute; width:1px; } .JCLRgripDrag{ border-left:1px dotted black;\t} .JCLRFlex{width:auto!important;} .JCLRgrip.JCLRdisabledGrip .JColResizer{cursor:default; display:none;}</style>");var g=function(t){var e=t.attr(n);(t=s[e])&&t.is("table")&&(t.removeClass(l+" "+c).gc.remove(),delete s[e])},u=function(i){var r=i.find(">thead>tr:first>th,>thead>tr:first>td");r.length||(r=i.find(">tbody>tr:first>th,>tr:first>th,>tbody>tr:first>td, >tr:first>td")),i.cg=i.find("col"),i.ln=r.length,i.p&&e&&e[i.id]&&w(i,r),r.each(function(e){var r="";if(0!=colWidth.length)r=colWidth[e];var o=t(this),s=-1!=i.dc.indexOf(e),d=t(i.gc.append('<div class="JCLRgrip"></div>')[0].lastChild);d.append(s?"":i.opt.gripInnerHtml).append('<div class="'+l+'"></div>'),e==i.ln-1&&(d.addClass("JCLRLastGrip"),i.f&&d.html("")),d.bind("touchstart mousedown",R),s?d.addClass("JCLRdisabledGrip"):d.removeClass("JCLRdisabledGrip").bind("touchstart mousedown",R),d.t=i,d.i=e,d.c=o,o.w=""!=r?r:o.width(),i.g.push(d),i.c.push(o),o.width(o.w).removeAttr("width"),d.data(l,{i:e,t:i.attr(n),last:e==i.ln-1})}),i.cg.removeAttr("width"),i.find("td, th").not(r).not("table th, table td").each(function(){t(this).removeAttr("width")}),i.f||i.removeAttr("width").addClass(c),v(i)},w=function(t,i){var r,o,s=0,d=0,n=[];if(i){if(t.cg.removeAttr("width"),t.opt.flush)return void(e[t.id]="");for(o=(r=e[t.id].split(";"))[t.ln+1],!t.f&&o&&(t.width(o*=1),t.opt.overflow&&(t.css("min-width",o+a),t.w=o));d<t.ln;d++)n.push(100*r[d]/r[t.ln]+"%"),i.eq(d).css("width",n[d]);for(d=0;d<t.ln;d++)t.cg.eq(d).css("width",n[d])}else{for(e[t.id]="";d<t.c.length;d++)r=t.c[d].width(),e[t.id]+=r+";",s+=r;e[t.id]+=s,t.f||(e[t.id]+=";"+t.width())}},v=function(t){1==giveTableWidth&&($(document).find("table.egt_form_table").css({"min-width":t.w+"px"}),giveTableWidth=0),t.gc.width(t.w);for(var e=0;e<t.ln;e++){var i=t.c[e];t.g[e].css({left:i.offset().left-t.offset().left+i.outerWidth(!1)+t.cs/2+a,height:t.opt.headerOnly?t.c[0].outerHeight(!1):t.outerHeight(!1)})}},m=function(t,e,i){var r=o.x-o.l,s=t.c[e],d=t.c[e+1],n=s.w+r,l=d.w-r;s.width(n+a),t.cg.eq(e).width(n+a),t.f?(d.width(l+a),t.cg.eq(e+1).width(l+a)):t.opt.overflow&&t.css("min-width",t.w+r),i&&(s.w=n,d.w=t.f?l:d.w)},C=function(e){var i=t.map(e.c,function(t){return t.width()});e.width(e.w=e.width()).removeClass(c),t.each(e.c,function(t,e){e.width(i[t]).w=i[t]}),e.addClass(c)},b=function(t){if(o){var e=o.t,i=t.originalEvent.touches,r=(i?i[0].pageX:t.pageX)-o.ox+o.l,s=e.opt.minWidth,d=o.i,n=1.5*e.cs+s+e.b,l=d==e.ln-1,c=d?e.g[d-1].position().left+e.cs+s:n,h=e.f?d==e.ln-1?e.w-n:e.g[d+1].position().left-e.cs-s:1/0;if(r=f.max(c,f.min(h,r)),o.x=r,o.css("left",r+a),l){var p=e.c[o.i];o.w=p.w+r-o.l}if(e.opt.liveDrag){l?(p.width(o.w),!e.f&&e.opt.overflow?e.css("min-width",e.w+r-o.l):e.w=e.width()):m(e,d),v(e);var g=e.opt.onDrag;g&&(t.currentTarget=e[0],g(t))}return!1}},x=function(r){if(i.unbind("touchend."+l+" mouseup."+l).unbind("touchmove."+l+" mousemove."+l),t("head :last-child").remove(),o){if(o.removeClass(o.t.opt.draggingClass),o.x-o.l!=0){var s=o.t,d=s.opt.onResize,n=o.i,a=n==s.ln-1,c=s.g[n].c;a?(c.width(o.w),c.w=o.w):m(s,n,!0),s.f||C(s),v(s),d&&(r.currentTarget=s[0],d(r)),s.p&&e&&w(s)}o=null}},R=function(e){var d=t(this).data(l),n=s[d.t],a=n.g[d.i],c=e.originalEvent.touches;if(a.ox=c?c[0].pageX:e.pageX,a.l=a.position().left,a.x=a.l,i.bind("touchmove."+l+" mousemove."+l,b).bind("touchend."+l+" mouseup."+l,x),r.append("<style type='text/css'>*{cursor:"+n.opt.dragCursor+"!important}</style>"),a.addClass(n.opt.draggingClass),o=a,n.c[d.i].l)for(var h,f=0;f<n.ln;f++)(h=n.c[f]).l=!1,h.w=h.width();return!1};t(window).bind("resize."+l,function(){for(var t in s)if(s.hasOwnProperty(t)){var i,r=0;if((t=s[t]).removeClass(l),t.f){for(t.w=t.width(),i=0;i<t.ln;i++)r+=t.c[i].w;for(i=0;i<t.ln;i++)t.c[i].css("width",f.round(1e3*t.c[i].w/r)/10+"%").l=!0}else C(t),"flex"==t.mode&&t.p&&e&&w(t);v(t.addClass(l))}}),t.fn.extend({colResizable:function(e){switch((e=t.extend({resizeMode:"fit",draggingClass:"JCLRgripDrag",gripInnerHtml:"",liveDrag:!1,minWidth:15,headerOnly:!1,hoverCursor:"e-resize",dragCursor:"e-resize",postbackSafe:!1,flush:!1,marginLeft:null,marginRight:null,disable:!1,partialRefresh:!1,disabledColumns:[],onDrag:null,onResize:null},e)).fixed=!0,e.overflow=!1,e.resizeMode){case"flex":e.fixed=!1;break;case"overflow":e.fixed=!1,e.overflow=!0}return this.each(function(){!function(e,i){var o=t(e);if(o.opt=i,o.mode=i.resizeMode,o.dc=o.opt.disabledColumns,o.opt.disable)return g(o);var a=o.id=o.attr(n)||l+d++;o.p=o.opt.postbackSafe,!o.is("table")||s[a]&&!o.opt.partialRefresh||("e-resize"!==o.opt.hoverCursor&&r.append("<style type='text/css'>.JCLRgrip .JColResizer:hover{cursor:"+o.opt.hoverCursor+"!important}</style>"),o.addClass(l).attr(n,a).before('<div class="JCLRgrips"/>'),o.g=[],o.c=[],o.w=o.width(),o.gc=o.prev(),o.f=o.opt.fixed,i.marginLeft&&o.gc.css("marginLeft",i.marginLeft),i.marginRight&&o.gc.css("marginRight",i.marginRight),o.cs=h(p?e.cellSpacing||e.currentStyle.borderSpacing:o.css("border-spacing"))||2,o.b=h(p?e.border||e.currentStyle.borderLeftWidth:o.css("border-left-width"))||1,s[a]=o,u(o))}(this,e)})}})}(jQuery);

        $(function(){
            var onSampleResized = function(e){
                var table = $(e.currentTarget); //reference to the resized table
            };
            $("table.egt_form_table").colResizable({
                // fixed:false,
                /*disabledColumns: [0],*/
               /* headerOnly: true,*/
                liveDrag:true,
                // gripInnerHtml:"<div class='grip'></div>",
                resizeMode:'overflow',
                draggingClass:"dragging",
                onResize:onSampleResized,
                fixedWidths: colWidth
            });
        });
    }
    $(document).ready(function() {
        updateHiddenFields();
        if(colWidth.length != 0){
            var twid = 0;
            colWidth.forEach(function(item,index){
                if(!colHide.includes(index)){
                    twid = twid + item;
                }
            })
            if(twid > $('.table-scroll').width()){
                $(document).find('table.egt_form_table').css({'min-width':twid+'px'});
            }
        }
        table_th_resize();
    });
    $('.listing_dropdown>li>label>input[type="checkbox"]').on('click', function(e) {
        $( "table.egt_form_table" ).colResizable({ disable : true });
        colWidth = [];
        $('.egt_form_header>tr>th').each(function(index){
            colWidth.push(parseFloat($(this).width()));
        });

        var val = $(this).val();

        $('table.egt_form_table>thead>tr').find('th:eq('+val+')').toggle();
        $('table.egt_form_table>thead>tr').find('td:eq('+val+')').toggle();
        $('table.egt_form_table>tbody>tr').find('td:eq('+val+')').toggle();
        $('table.egt_form_table>tfoot>tr').find('td:eq('+val+')').toggle();
        colHide = [];
        $('.egt_form_header>tr>th').each(function(index){
            if($(this).css("display") == 'none'){
                colHide.push(index);
            }
        });
        colWidth[colWidth.length-1] = 45;
        giveTableWidth = 1;
        console.log(colWidth);
        hiddenFiledsCount();
        $( "table.egt_form_table" ).colResizable({
          /*  headerOnly: true,*/
            liveDrag:true,
            // gripInnerHtml:"<div class='grip'></div>",
            resizeMode:'overflow',
            draggingClass:"dragging",
            fixedWidths: colWidth
        });
        $(document).find('.JCLRgrips').find('.JCLRgrip:eq('+val+')').css({display:''});
    });
    function hiddenFiledsCount(){
        var count = 0;
        var hiddenFiled = [];
        $('.dropdown-menu>li').each(function(){
            if(!$(this).find('label>input').is(':checked')){
                if($(this).find('label>input').val() !== undefined){
                    count += 1;
                    hiddenFiled.push($(this).find('label>input').val());
                }
            }
        });
        $('.hiddenFiledsCount>span').html(count);
    }

    function updateHiddenFields(){
        $('.hiddenFiledsCount>span').html(colHide.length);
        for(var i=0;i < colHide.length; i++){
            $('.dropdown-menu>li').each(function(){
                if($(this).find('label>input').val() == colHide[i]){
                    $(this).find('label>input').prop('checked',false)
                    $('table.egt_form_table>thead>tr').find('th:eq('+colHide[i]+')').hide();
                    $('table.egt_form_table>thead>tr').find('td:eq('+colHide[i]+')').hide();
                    $('table.egt_form_table>tbody>tr').each(function(){
                        $(this).find('td:eq('+colHide[i]+')').hide();
                        $(this).find('td:eq('+colHide[i]+')>input').removeClass('tb_moveIndex');
                        $(this).find('td:eq('+colHide[i]+')>select').removeClass('tb_moveIndex');
                    });
                    $('table.egt_form_table>tfoot>tr').find('td:eq('+colHide[i]+')').hide();
                }
            });
        }
    }
</script>
