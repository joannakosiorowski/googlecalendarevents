
 <div class="modal fade" id="holidayjackpotModal" tabindex="-1" role="dialog" aria-labelledby="holidayjackpotModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="holidayjackpotModalLabel"></h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
        <form action="{{route('report')}}" method="POST" >@csrf
        <div class="form-group">
            <label for="hash">Wprowadź znacznik</label>
            <input type="text" class="form-control inputDate"  name="hash" value=""  />
        </div>
        <button type="submit" class="btn btn-primary">Zatwierdź</button>
        </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary" data-dismiss="modal">Zamknij</button>
        </div>
      </div>
    </div>
  </div>


