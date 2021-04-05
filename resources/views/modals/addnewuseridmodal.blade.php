
  <div class="modal fade" id="userIdModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Dodaj ID kalendarza nowego użytkownika</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form action="" method="post">@csrf
          
                <div class="form-group">
                    <label for="name">Podaj imię i nazwisko</label>
                    <input type="text" class="form-control" name="name"  />
                  </div>
                  <div class="form-group">
                    <label for="calendarID">Podaj ID kalendarza</label>
                    <input type="text" class="form-control" name="calendarID"  />
                  </div>
                  <button type="submit" class="btn btn-primary">Zatwierdź</button>
            </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>


