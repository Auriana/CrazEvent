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
                              notificationsRead[idNotification] = obj.result.content;
                              $('#notificationContent').html(obj.result.content);
                          }
                          else {
                              console.log(obj.error);
                          }
                    }
            });
        } else {
            $('#notificationContent').html(notificationsRead[idNotification]);
        }
    }
    
    $(document).ready(function(){
        $('.notification-notRead').click(function() {
            //special display of read notification
            $(this).addClass('notification-read');
            $(this).removeClass('notification-notRead');
            
            //special display of selected notification
            $( ".notification-selected" ).each(function( index ) {
                $(this).removeClass('notification-selected');
            });
            $(this).addClass('notification-selected');
        });
        
        $('.notification-read').click(function() {
            //special display of selected notification
            $( ".notification-selected" ).each(function( index ) {
                $(this).removeClass('notification-selected');
            });
            $(this).addClass('notification-selected');
        });
    });
</script>
<div class="container theme-showcase" role="main">
	<div class="col-md-10 white-bloc centred">
		<h1 class="text-centred">
			Mes notifications
		</h1>
        <?php
            if(isset($notifications)) {
				echo '<ul class="result_search">';
				foreach ($notifications as $notification) {
					echo '<li onclick="readNotification('.$notification->messageId.')" class="'.($notification->is_read == 1 ? 'star-t' : 'star-r').'">'.$notification->content." par ".$notification->senderFirstname." ".$notification->senderSurname;
					echo ' ('.$notification->date.')'; 
					echo '<a class="list_contact" href="'. base_url('details_event/index/' . $notification->messageId) . '">Voir l\'évènement</a><div class="clearer"></div></li>';
				}		
                echo "</ul>";
			}
        ?>
        </div>
	</div>