<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>

<?php echo validation_errors(); ?>

<div class="col-md-12 white-bloc centred">
	<h1 class="text-centred">
		Agenda
	</h1>
    
    <?php echo form_open( 'calendar', 'name="calendarChange" class="form-horizontal" role="form"'); ?>
        <p>
            Mois : 
            <select name="inputMonth" onchange="this.form.submit()">
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
            <select name="inputYear" onchange="this.form.submit()">
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
    </form>
    <?php echo $calendar; ?>
</div>

</div>