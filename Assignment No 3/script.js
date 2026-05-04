$(document).ready(function() {
    // --- 1. Integer Array Logic --- \\
    let integerArray = [];

    // Set Array from comma-separated input
    $('#addIntBtn').click(function() {
        const inputStr = $('#intInput').val();
        if (inputStr.trim() === '') {
            integerArray = [];
        } else {
            // Split by comma, trim whitespace, convert to integers, and filter out NaN values
            integerArray = inputStr.split(',')
                .map(item => parseInt(item.trim(), 10))
                .filter(item => !isNaN(item));
        }
        updateIntDisplay();
        $('#intSearchResult').text(''); // Clear previous search result
    });

    // Sort Ascending
    $('#sortAscBtn').click(function() {
        if(integerArray.length > 0) {
            integerArray.sort((a, b) => a - b);
            updateIntDisplay();
        }
    });

    // Sort Descending
    $('#sortDescBtn').click(function() {
        if(integerArray.length > 0) {
            integerArray.sort((a, b) => b - a);
            updateIntDisplay();
        }
    });

    // Search Integer
    $('#searchIntBtn').click(function() {
        const searchInput = $('#searchInt').val();
        if (searchInput.trim() === '') {
            showResult('#intSearchResult', 'Please enter a number to search', 'text-warning');
            return;
        }

        const target = parseInt(searchInput, 10);
        // Using standard JavaScript array searching
        const index = integerArray.indexOf(target);
        
        if (index !== -1) {
            showResult('#intSearchResult', `Found <strong>${target}</strong> at position <strong>${index}</strong>`, 'text-success');
        } else {
            showResult('#intSearchResult', `<strong>${target}</strong> was not found in the array`, 'text-danger');
        }
    });

    // Helper to update the integer display
    function updateIntDisplay() {
        $('#intDisplay').text('[' + integerArray.join(', ') + ']');
    }


    // --- 2. Named Entities Logic --- \\
    let entitiesArray = [];

    // Add Entity
    $('#addEntityBtn').click(function() {
        const entityStr = $('#entityInput').val().trim();
        if (entityStr !== '') {
            entitiesArray.push(entityStr);
            $('#entityInput').val(''); // Clear input box
            updateEntityDisplay();
            $('#entitySearchResult').text(''); // Clear previous search result
        }
    });

    // Optional: Allow pressing Enter to add entity
    $('#entityInput').keypress(function(e) {
        if(e.which == 13) {
            $('#addEntityBtn').click();
        }
    });

    // Sort Entities Alphabetically
    $('#sortEntityBtn').click(function() {
        if(entitiesArray.length > 0) {
            // Locale compare handles case-insensitive sorting gracefully
            entitiesArray.sort((a, b) => a.localeCompare(b));
            updateEntityDisplay();
        }
    });

    // Search Entity
    $('#searchEntityBtn').click(function() {
        const target = $('#searchEntity').val().trim();
        if (target === '') {
            showResult('#entitySearchResult', 'Please enter a name to search', 'text-warning');
            return;
        }

        // Using standard JavaScript array searching (case-insensitive)
        const index = entitiesArray.findIndex(item => item.toLowerCase() === target.toLowerCase());

        if (index !== -1) {
            showResult('#entitySearchResult', `Found <strong>${entitiesArray[index]}</strong> at position <strong>${index}</strong>`, 'text-success');
        } else {
            showResult('#entitySearchResult', `<strong>${target}</strong> not found`, 'text-danger');
        }
    });

    // Helper to update entities list rendering
    function updateEntityDisplay() {
        const $list = $('#entityList');
        $list.empty();
        
        if (entitiesArray.length === 0) {
            $list.append('<li class="list-group-item text-muted text-center font-italic bg-transparent border-0">No entities added yet</li>');
        } else {
            // Using jQuery's each function to iterate array
            $.each(entitiesArray, function(index, entity) {
                const li = $(`
                    <li class="list-group-item d-flex justify-content-between align-items-center bg-transparent border-bottom">
                        ${entity}
                        <span class="badge bg-secondary rounded-pill">${index}</span>
                    </li>
                `);
                $list.append(li);
            });
        }
    }

    // A small helper to show search results with color classes
    function showResult(selector, htmlContent, colorClass) {
        $(selector)
            .html(htmlContent)
            .removeClass('text-success text-danger text-warning')
            .addClass(colorClass);
    }

    // Initial renders
    updateEntityDisplay();
});
