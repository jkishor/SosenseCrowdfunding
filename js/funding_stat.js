
				function setProgress(progress,dealid){ 
                         var id ="progess_bar_"+dealid;	
                            //alert(id);						 
					var progressBarWidth =progress*jQuery(".progressbarcontainer1").width()/ 100;
					if(progress < 1) {
						jQuery("#"+id+".progressbar1").width(progressBarWidth);
					} else if(progress >= 100) {
						progressBarWidth = parseInt(jQuery(".progressbarcontainer1").width()) + parseInt(7);
						
						jQuery("#"+id+".progressbar1").width(progressBarWidth);
					} else {
						jQuery("#"+id+".progressbar1").width(progressBarWidth);
					}	
				}
				
				function setonlyProgress(progress,dealid){ 
                         var id ="progess_only_bar_"+dealid;	
                            //alert(id);						 
					var progressBarWidth =progress*jQuery(".progressbarcontainer1").width()/ 100;
					if(progress < 1) {
						jQuery("#"+id+".progressbar2").width(progressBarWidth);
						jQuery("#"+id+".progressbar2").html('<1%');
					} else if(progress >= 100) {
						progressBarWidth = parseInt(jQuery(".progressbarcontainer1").width()) + parseInt(7);
						jQuery("#"+id+".progressbar2").html(progress+'%');
						jQuery("#"+id+".progressbar2").width('100%');
					} else {
						jQuery("#"+id+".progressbar2").width(progressBarWidth);
						jQuery("#"+id+".progressbar2").html(progress+'%');
					}	
				}
				
				

