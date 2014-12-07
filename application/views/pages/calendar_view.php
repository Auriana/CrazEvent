<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>

<?php echo validation_errors(); ?>
<div class="container theme-showcase" role="main">
<div class="col-md-12 white-bloc centred">
	<h1 class="text-centred">
		Agenda
	</h1>
    <div class="col-md-3 centred small-marg">
    <?php echo form_open( 'calendar', 'name="calendarChange" class="form-inline" role="form"'); ?>
        <div class="form group" >
			<label class="inputMonth" for="inputMonth">Mois</label>  
            <select class="form-control" name="inputMonth" onchange="this.form.submit()">
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

			<label class="inputYear" for="inputYear">Année</label>         
            <select class="form-control" name="inputYear" onchange="this.form.submit()">
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
        </div>	
    </form>
	</div>
	<div class="centred small-marg">
    	<?php echo $calendar; ?>
	</div>
</div>

</div>