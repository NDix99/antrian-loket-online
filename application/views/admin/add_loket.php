<div class="container-fluid">
  <div class="row justify-content-center">
    <div class="col-md-6 col-sm-8 col-xs-8">
      <div class="card m-4 border-success shadow-lg">
        <div class="card-header text-center bg-success text-white">
          <h4 class="fw-bold">Tambah Loket</h4>
        </div>
        <div class="card-body p-4">
          <form method="POST" action="<?= site_url('admin/add_loket'); ?>" enctype="multipart/form-data">
            <div class="form-group mb-4">
              <select name="no_loket" id="no_loket" class="form-control">
                <label for="sel1" id="l1">Nomor Loket</label>
                <option value="">--Pilih Loket--</option>
                <?php foreach ($lokets as $loket) : ?>
                  <option value="<?= $loket->no_loket; ?>"><?= $loket->no_loket; ?></option>
                <?php endforeach; ?>
              </select>
            </div>

            <div class="form-group mb-4">
              <select name="user_id" id="user_id" class="form-control">
                <label for="sel1" id="l1">User Loket</label>
                <option value="0">--Pilih User--</option>
                <?php foreach ($users as $user) : ?>
                  <option value="<?= $user->name; ?>"><?= $user->name; ?></option>
                <?php endforeach; ?>
              </select>
              </select>
            </div>

            <div class="form-group mb-4">
              <div class="form-check form-switch" id="checkboxContainer">
                <label class="form-check-label" for="flexSwitchCheckDefault">Status Loket Aktif</label>
                <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckDefault">
              </div>
            </div>
            <div class="d-flex justify-content-center">
              <button type="submit" class="btn btn-primary pe-2" name="simpan_loket">Simpan</button>
              <button type="reset" class="btn btn-danger">Reset</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>



<script>
  // Assume you have a variable isChecked that represents whether the checkbox should be shown (1) or hidden (0)
  var isChecked = 1; // Replace this with your actual condition or variable

  // Get the container element by its ID
  var container = document.getElementById("checkboxContainer");

  // Get the checkbox element by its ID
  var checkbox = document.getElementById("flexSwitchCheckDefault");

  // Set the visibility based on the condition
  container.style.display = isChecked == 1 ? 'block' : 'none';

  // Alternatively, you can use the style.display directly on the checkbox
  // checkbox.style.display = isChecked == 1 ? 'block' : 'none';
</script>