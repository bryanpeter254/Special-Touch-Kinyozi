# Special-Touch-Kinyozi
A Barbershop system showing details for day to day activities 

<select name="offered_by_id" id="offered_by_id" required>
  <option value="">-- Select Barber --</option>
  <?php
  $barbersResult = $conn->query("SELECT id, name FROM barbers ORDER BY name ASC");
  if ($barbersResult && $barbersResult->num_rows > 0) {
      while ($barber = $barbersResult->fetch_assoc()) {
          echo "<option value='" . $barber['id'] . "'>" . htmlspecialchars($barber['name']) . "</option>";
      }
  }
  ?>
</select>

<!-- Submit Button -->
<button type="submit" class="btn btn-success mt-2">
    <i class="bi bi-plus-circle"></i> Add Revenue
</button>

<hr>


