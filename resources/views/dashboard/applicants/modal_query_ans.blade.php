<?php foreach ($data as $singleData) { ?>
<div class="form-row">
    <div class="col-md-12">
        <div class="position-relative form-group">
            <label for="ans" class="">{{ $singleData->Question }}</label>
            <textarea name="ans" type="textarea" class="form-control" required>{{ $singleData->Answer }}</textarea>
        </div>
    </div>
</div>
<?php
$Aid=$singleData->ApplicantId;
}
$title='" REG-ID-'.$Aid.' => Interview Query Details"';
echo "<script>$('#exampleModalLongTitle').text(".$title.");</script>";
?>
