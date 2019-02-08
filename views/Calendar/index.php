<h1 class="h2">Kalendarz</h1>
<hr>
<div id="calendar" class="col-centered"></div>

<!-- FullCalendar -->
<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script src="https://momentjs.com/downloads/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.0/fullcalendar.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.0/locale-all.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.0/fullcalendar.min.css">

<script>
    $(document).ready(function() {

        $('#calendar').fullCalendar({
            locale: 'pl',
            header: {
                left: 'prev, next today',
                center: 'title',
                right: 'month, basicWeek, basicDay, list'
            },
            defaultDate: new Date(),
            editable: true,
            eventLimit: true, // allow "more" link when too many events
            selectable: true,
            selectHelper: true,
            events: [
                <?php foreach($viewModel as $event):
                    $start = explode(" ", $event['start_date']);
                    $end = explode(" ", $event['end_date']);
                    if($start[1] == '00:00:00')

                    {
                        $start = $start[0];
                    }else
                    {
                        $start = $event['start_date'];
                    }

                    if($end[1] == '00:00:00')
                    {
                        $end = $end[0];
                    }else
                    {
                        $end = $event['end_date'];
                    }
                ?>
                    {
                        id: '<?php echo $event['id']; ?>',
                        title: '<?php echo $event['name']; ?>',
                        start: '<?php echo $start; ?>',
                        end: '<?php echo $end; ?>',
                        color: '<?php echo $event['color']; ?>',
                        url: '/tasks/show/<?php echo $event['id']; ?>',
                    },
                <?php endforeach; ?>
            ],
            eventClick: function(event) {
                if (event.url) {
                    window.open(event.url);
                    return false;
                }
            }
        });
    });
</script>
