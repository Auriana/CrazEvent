<script>
    var notificationsRead = new Object();
    //retrieve the content of the notification
    function readNotification(idNotification) {
        //do not query the server if notification already received
        if(!(idNotification in notificationsRead)) {
            $.ajax({
            type: "GET",
            url: '/notification/read_notification?id='+idNotification,
            dataType: "json",

            success: function (obj, textstatus) {
                          if( !('error' in obj) ) {
                              notificationsRead[idNotification] = 1;
                          }
                          else {
                              console.log(obj.error);
                          }
                    }
            });
        }
    }
    
    $(document).ready(function(){
        $('.star-r').click(function() {
            //special display of read notification
            $(this).addClass('star-t');
            $(this).removeClass('star-r');
        });
    });
</script>
<div class="container theme-showcase" role="main">
	<div class="col-md-10 white-bloc centred">
		<h1 class="text-centred">
			Notifications
		</h1>
        <div class="col-md-5 centred small-marg">
			<p class="text-centred">
            <?php
                if($previousOffset >= 0) {
                    echo '<a href="'.base_url().'notification/index/'.$previousOffset.'"> <span class="next-prev glyphicon glyphicon-circle-arrow-left" aria-hidden="Page précédente"></span> </a> ';
                }
                if(true) {   
                   echo '<a href="'.base_url().'notification/index/'.$nextOffset.'"> <span class="next-prev glyphicon glyphicon-circle-arrow-right" aria-hidden="Page suivante"></span> </a>';
                }
            ?>
			</p>
	    </div>
		<p>
			<b>Pour valider la lecture d'une nouvelle notification, clique dessus !</b>
		</p>
        <?php
            if(isset($notifications)) {
				echo '<ul class="result_search">';
				foreach ($notifications as $notification) {
					echo '<li onclick="readNotification('.$notification->messageId.')" class="'.($notification->is_read == 1 ? 'star-t' : 'star-r clickOn').'">';
                    echo $notification->subject.'</br>'.$notification->content.' ('.$notification->date.')'; 
                    echo '<div class="clearer"></div>';
                    echo '</li>';
				}		
                echo "</ul>";
			}
        ?>
        </div>
	</div>