<!DOCTYPE html>

<html>

<head>

    <title>Pdf Design</title>
    <script src="https://wizard.net.nz/assets/js/jquery-3.2.1.min.js" type="text/javascript"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>


    <!--<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/canvg/1.5/canvg.min.js"></script>-->
    
    
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.0.272/jspdf.debug.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.js"></script>
    
        <!-- Gantt Chart-->
            <link rel=stylesheet href="https://wizard.net.nz/assets/Gantt/platform.css" type="text/css">
            <link rel=stylesheet href="https://wizard.net.nz/assets/Gantt/libs/jquery/dateField/jquery.dateField.css" type="text/css">
        
            <link rel=stylesheet href="https://wizard.net.nz/assets/Gantt/gantt.css" type="text/css">
            <link rel=stylesheet href="https://wizard.net.nz/assets/Gantt/ganttPrint.css" type="text/css" media="print">
            
            <script src="https://wizard.net.nz/assets/Gantt/libs/jquery/jquery.livequery.1.1.1.min.js"></script>
            <!--Gantt-->
          <script src="https://wizard.net.nz/assets/Gantt/libs/jquery/jquery.timers.js"></script>
        
          <script src="https://wizard.net.nz/assets/Gantt/libs/utilities.js"></script>
          <script src="https://wizard.net.nz/assets/Gantt/libs/forms.js"></script>
          <script src="https://wizard.net.nz/assets/Gantt/libs/date.js"></script>
          <script src="https://wizard.net.nz/assets/Gantt/libs/dialogs.js"></script>
          <script src="https://wizard.net.nz/assets/Gantt/libs/layout.js"></script>
          <script src="https://wizard.net.nz/assets/Gantt/libs/i18nJs.js"></script>
          <script src="https://wizard.net.nz/assets/Gantt/libs/jquery/dateField/jquery.dateField.js"></script>
          <script src="https://wizard.net.nz/assets/Gantt/libs/jquery/JST/jquery.JST.js"></script>
          <script src="https://wizard.net.nz/assets/Gantt/libs/jquery/valueSlider/jquery.mb.slider.js"></script>
        
          <script type="text/javascript" src="https://wizard.net.nz/assets/Gantt/libs/jquery/svg/jquery.svg.min.js"></script>
          <script type="text/javascript" src="https://wizard.net.nz/assets/Gantt/libs/jquery/svg/jquery.svgdom.1.8.js"></script>
        
        
          <script src="https://wizard.net.nz/assets/Gantt/ganttUtilities.js"></script>
          <script src="https://wizard.net.nz/assets/Gantt/ganttTask.js"></script>
          <script src="https://wizard.net.nz/assets/Gantt/ganttDrawerSVG.js"></script>
          <script src="https://wizard.net.nz/assets/Gantt/ganttZoom.js"></script>
          <script src="https://wizard.net.nz/assets/Gantt/ganttGridEditor.js"></script>
          <script src="https://wizard.net.nz/assets/Gantt/ganttMaster.js"></script> 
          <script>
              var base_url = "https://wizard.net.nz/";
          </script>
          <style>
              /*.noprint{
                  display:none;
              }
              .vSplitBar{
                  left:654px!important;
              }
              .splitBox1{
                  width:651px!important;
              }
              .splitBox2{
                  left:656px!important;
                  width:auto!important;
              }
              .workSpace_container, #workSpace{
                  overflow: visible !important;
                  width: auto !important;
                  height: auto !important;
                  max-height: auto !important;
              }
              .splitElement{
                  overflow-y:visible!important;
              }
              #TWGanttArea{
                  overflow:visible!important;
              }
              @media print {
                .vSplitBar{
                  display:none;
              }*/
              
              .splitBox2{
                  /*overflow-y:hidden;!important;*/
              }
      }
          </style>
          

</head>

<body>
            <input type="hidden" name="original_project_id" id="original_project_id" value="<?php echo $project_id;?>">
            <h2 class="pull-left" style="margin-top:20px;margin-left:10px;"><?php echo get_project_name($project_id);?></h2>
            <button class="btn btn-success pull-right" style="margin-top:20px;" onclick="Print();">Download</button>
        
            <div class="workSpace_container" style="padding:80px 0px;">
            
    </div>
</div>


       
        <script type="text/javascript">
        loadGanttChart();
        $(document).ready(function() {
           loadGanttChart();
        });
        function loadGanttChart(){
            var project_id = $("#original_project_id").val();
            var date_range = "<?php echo $daterange;?>";
            date_range = date_range.split("/").join("-");
            $.ajax({
                        type:'POST',
                        url:'https://wizard.net.nz/projects/set_daterange',
                        data: {date_range:date_range, project_id:project_id},
                        success:function(result){
                             $(".workSpace_container").html(result);
                             
                        }
            }); 
        }
        
        function getPDFFileButton () {
            $(".splitBox1").attr("id", "splitBox1");
            $(".splitBox2").attr("id", "splitBox2");
            let scrollWidth1 = document.getElementById("splitBox1").scrollWidth;
            let scrollWidth2 = document.getElementById("splitBox2").scrollWidth;
            let totalWidth = parseFloat(scrollWidth1) + parseFloat(scrollWidth2);
            let scrollHeight = document.getElementById("splitBox1").scrollHeight;
            
            //$(".splitBox1").width(scrollWidth1);
            $(".splitBox1").css("width", scrollWidth1);
            $(".vSplitBar").css("left", scrollWidth1);
            $(".splitBox2").css("left", scrollWidth1);
            //$(".splitBox2").width(scrollWidth2);
            $(".splitBox2").css("width", scrollWidth2);
            $(".splitBox2").css("height", "100%");
            
            $("#TWGanttArea").width(totalWidth);
            $("#TWGanttArea").css("width", totalWidth);
            $("#TWGanttArea").css("height", scrollHeight);
            $("#TWGanttArea").css("overflow", "hidden auto");
            var element = document.getElementById("TWGanttArea");

            html2canvas(element).then(function(canvas) {
                var myImage = canvas.toDataURL("image/jpeg,1.0");
                
                // Adjust width and height
                var imgWidth = (canvas.width * 20) / 240;
                var imgHeight = (canvas.height * 5) / 60;
                // jspdf changes
                var project_name = "<?php echo get_project_name($this->uri->segment(3));?>";
                
                var pdf = new jsPDF('l', 'mm', [totalWidth, scrollHeight]);
                pdf.setFontSize(50);
                pdf.text(20, 20, project_name);
                pdf.addImage(myImage, 'JPEG', 20, 40);
                pdf.save(project_name+'.pdf');

                $(".splitBox2").width("100%");
                //$(".splitBox2").css("overflow", "hidden auto");
            });


		}
 
        function Print(){

            getPDFFileButton();
           
        }
        
       
            
        </script>


</body>

</html>