<div class="modal fade" id="modal-lg">
    <div class="modal-dialog modal-lm">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Ви маєте можливість змінити статус перед збереженням. Оберіть статус.</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">{{ __('Відмінити') }}</button>
                <button type="button" onclick="saveFood(0)" class="btn btn-primary" data-dismiss="modal">{{ __('Залишити без змін') }}</button>
                <button type="button" onclick="saveFood(1)" class="btn btn-success" data-dismiss="modal">{{ __('На модерації') }}</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>



