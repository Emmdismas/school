<div>
    <!-- The best way to take care of the future is to take care of the present moment. - Thich Nhat Hanh -->
</div>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Form</title>
    <link rel="stylesheet" href="{{ asset('assets/css/assignment.css') }}">
</head>
<body>
    <div class="container">
        <header>
            <h2>Registration Form</h2>
        </header>
        <form action="{{ route('schools.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="_token" value="{{ csrf_token() }}">

            <div class="form-group">
                <label for="school-name">School Name:</label>
                <input type="text" id="school-name" name="school_name" placeholder="Enter school name" required>
            </div>

            <div class="form-group">
                <label for="school-id">School ID:</label>
                <input type="number" id="school-id" name="school_id" placeholder="Enter school id" required>
            </div>

            <!-- New School Type -->
            <div class="form-group">
                <label for="school-type">School Type:</label>
                <select id="school-type" name="school_type" required>
                    <option value="primary">Primary</option>
                    <option value="secondary">Secondary</option>
                    <option value="advance">Advanced</option>
                </select>
            </div>

            <!-- Region and District Selection -->
            <div class="form-group">
                <label for="region">Region:</label>
                <select id="region" name="region" required>
                    <option value="">Select Region</option>
                    <option value="Arusha">Arusha</option>
                    <option value="Dar es Salaam">Dar es Salaam</option>
                    <option value="Dodoma">Dodoma</option>
                    <option value="Mbeya">Mbeya</option>
                    <option value="Mwanza">Mwanza</option>
                </select>
            </div>

            <div class="form-group">
                <label for="district">District:</label>
                <select id="district" name="district" required>
                    <option value="">Select District</option>
                    <!-- District options will be populated based on Region -->
                </select>
            </div>

            <div class="form-group">
                <label for="school-fee">School Fee:</label>
                <input type="number" id="school-fee" name="school_fee" placeholder="Enter school fee" required>
            </div>

            

        <!-- Grading System Table -->
        <div id="grading-table" class="grading-table-container">
            <h3>Grading System Table</h3>
            <table>
                <thead>
                    <tr>
                        <th>Grade</th>
                        <th>From</th>
                        <th>Up To</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>A</td>
                        <td><input type="number" name="grade_A_from" value="{{ old('grade_A_from', 75) }}" required></td>
                        <td><input type="number" name="grade_A_to" value="{{ old('grade_A_to', 100) }}" required></td>
                    </tr>
                    <tr>
                        <td>B</td>
                        <td><input type="number" name="grade_B_from" value="{{ old('grade_B_from', 65) }}" required></td>
                        <td><input type="number" name="grade_B_to" value="{{ old('grade_B_to', 74) }}" required></td>
                    </tr>
                    <tr>
                        <td>C</td>
                        <td><input type="number" name="grade_C_from" value="{{ old('grade_C_from', 45) }}" required></td>
                        <td><input type="number" name="grade_C_to" value="{{ old('grade_C_to', 64) }}" required></td>
                    </tr>
                    <tr>
                        <td>D</td>
                        <td><input type="number" name="grade_D_from" value="{{ old('grade_D_from', 30) }}" required></td>
                        <td><input type="number" name="grade_D_to" value="{{ old('grade_D_to', 44) }}" required></td>
                    </tr>
                    <tr>
                        <td>F</td>
                        <td><input type="number" name="grade_F_from" value="{{ old('grade_F_from', 0) }}" required></td>
                        <td><input type="number" name="grade_F_to" value="{{ old('grade_F_to', 29) }}" required></td>
                    </tr>
                    <!-- Special grading for advanced -->
                    <tr class="special-grade" style="display: none;">
                        <td>E</td>
                        <td><input type="number" name="grade_E_from" value="{{ old('grade_E_from', 40) }}" required></td>
                        <td><input type="number" name="grade_E_to" value="{{ old('grade_E_to', 49) }}" required></td>
                    </tr>
                    <tr class="special-grade" style="display: none;">
                        <td>S</td>
                        <td><input type="number" name="grade_S_from" value="{{ old('grade_S_from', 35) }}" required></td>
                        <td><input type="number" name="grade_S_to" value="{{ old('grade_S_to', 39) }}" required></td>
                    </tr>
                    <tr class="special-grade" style="display: none;">
                        <td>F</td>
                        <td><input type="number" name="grade_F_from" value="{{ old('grade_F_from', 0) }}" required></td>
                        <td><input type="number" name="grade_F_to" value="{{ old('grade_F_to', 34) }}" required></td>
                    </tr>
                </tbody>
            </table>
        </div>
        
        <button type="submit" class="btn-primary">Register</button>
       
        </form>
    </div>

    <script>
        // Handle region change to update districts dynamically
        const regions = {
            "Arusha": ["Arusha", "Arumeru", "Ngorongoro", "Longido", "Monduli", "Karatu"],
            "Dar es Salaam": ["Kinondono", "Ilala", "Temeke", "Kigamboni", "Ubungo"],
            "Dodoma": ["Chamwino", "Dodoma", "Chemba", "Kondoa"],
            "Mbeya": ["Chunya", "Kyela", "Mbeya", "Rungwe", "Mbarali"],
            "Mwanza": ["Ilemela", "Nyamagana", "Kwimba", "Sengerema", "Ukerewe", "Magu", "Misungwi"]
        };

        document.getElementById('region').addEventListener('change', function() {
            const region = this.value;
            const districtSelect = document.getElementById('district');
            districtSelect.innerHTML = '<option value="">Select District</option>'; // Clear current options

            if (region && regions[region]) {
                regions[region].forEach(function(district) {
                    const option = document.createElement('option');
                    option.value = district;
                    option.textContent = district;
                    districtSelect.appendChild(option);
                });
            }
        });

        // Initially load districts for the first region
        document.getElementById('region').dispatchEvent(new Event('change'));

        // Handle School Type Change for Grading System
        const schoolTypeSelect = document.getElementById('school-type');
        const gradingTable = document.getElementById('grading-table');
        const specialGrades = document.querySelectorAll('.special-grade');
        const middleFRow = document.querySelector('tr:nth-child(5)'); // F ya katikati

        schoolTypeSelect.addEventListener('change', function() {
            if (this.value === 'advance') {
                gradingTable.style.display = 'block';

                // Onyesha grades za E na S
                specialGrades.forEach(grade => grade.style.display = 'table-row');

                // Ficha F ya katikati (katika Primary/Secondary F ipo moja tu ya mwisho)
                if (middleFRow) {
                    middleFRow.style.display = 'none';
                }
            } else {
                gradingTable.style.display = 'block';

                // Ficha grades za E na S
                specialGrades.forEach(grade => grade.style.display = 'none');

                // Rudisha F ya katikati kwa Primary/Secondary
                if (middleFRow) {
                    middleFRow.style.display = 'table-row';
                }
            }
        });

        // Trigger school type change to display correct grading system initially
        schoolTypeSelect.dispatchEvent(new Event('change'));

    </script>
</body>
</html>
