
  <div class="modal fade" id="testModal" tabindex="-1" role="dialog" aria-labelledby="testModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="testModalLabel">Zgłoś błąd</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form action="{{ route('errmessage') }}" method="get">@csrf
          
                <div class="form-group">
                    <label for="email">Wyślij informację o błędzie do biura</label>
                    <textarea type="text" class="form-control" name="body" ></textarea>
                  </div>
                  <button type="submit" class="btn btn-primary">Wyślij</button>
            </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary" data-dismiss="modal">Zamknij</button>
        </div>
      </div>
    </div>
  </div>


