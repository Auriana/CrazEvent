<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<   

<?php echo validation_errors(); ?>
<?php echo form_open( 'verify_create_event', 'name="eventCreation" class="form-horizontal" role="form" onsubmit="return validateForm()"'); ?>

<div class="col-md-12 white-bloc centred">
	<h1 class="text-centred">
		Agenda
	</h1>
    <p>
        Mois : 
        <select name="inputMonth">
            <?php
                for ($i = 1; $i <= 12; $i++) {
                    if($i == $selectedMonth) {
                        echo '<option value="'.$i.'" selected>'.$i.'</option>';
                    } else {
                        echo '<option value="'.$i.'">'.$i.'</option>';
                    }
                }
            ?>
        </select>
        Année :
        <select name="inputYear">
            <?php
                for ($i = date("Y")-10; $i <= date("Y")+10; $i++) {
                    if($i == $selectedYear) {
                        echo '<option value="'.$i.'" selected>'.$i.'</option>';
                    } else {
                        echo '<option value="'.$i.'">'.$i.'</option>';
                    }
                }
            ?>
        </select>
    </p>
    <?php echo $calendar; ?>
</div>

</div>
</form>