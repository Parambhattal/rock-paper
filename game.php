<!DOCTYPE html>
<html>
<head>
    <title>e5c160fe - Rock Paper Scissors Game</title>
    <style>
        body { 
            font-family: Arial, sans-serif; 
            max-width: 800px; 
            margin: 0 auto; 
            padding: 20px; 
        }
        .header { 
            display: flex; 
            justify-content: space-between; 
            align-items: center; 
            margin-bottom: 20px;
        }
        input[type="submit"] { 
            padding: 15px 30px; 
            margin: 10px; 
            font-size: 18px; 
            cursor: pointer;
        }
        .result { 
            padding: 20px; 
            margin: 20px 0; 
            border-radius: 8px; 
            text-align: center;
            font-size: 24px; 
            font-weight: bold;
        }
        .win { background: #d4edda; color: #155724; }
        .lose { background: #f8d7da; color: #721c24; }
        .tie { background: #fff3cd; color: #856404; }
        table { 
            width: 100%; 
            border-collapse: collapse; 
            margin: 20px 0; 
        }
        th, td { 
            padding: 12px; 
            text-align: left; 
            border-bottom: 1px solid #ddd; 
        }
        th { 
            background-color: #f2f2f2; 
        }
        select {
            padding: 10px;
            font-size: 16px;
            margin: 10px 0;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Rock Paper Scissors</h1>
        <div>
            <?php
            // Simple PHP to get username from URL
            $user = isset($_GET['user']) ? htmlentities($_GET['user']) : 'Player';
            echo "Welcome " . $user . " | ";
            ?>
            <a href="login.html">Logout</a>
        </div>
    </div>

    <?php
    // Simple PHP session simulation
    if (isset($_POST['human'])) {
        $human = $_POST['human'];
        $computer = ['rock', 'paper', 'scissors'][array_rand(['rock', 'paper', 'scissors'])];
        
        function check($human, $computer) {
            if ($human == $computer) return "Tie";
            if (($human == 'rock' && $computer == 'scissors') ||
                ($human == 'scissors' && $computer == 'paper') ||
                ($human == 'paper' && $computer == 'rock')) {
                return "You Win";
            }
            return "You Lose";
        }
        
        $result = check($human, $computer);
        
        echo "<div class='result ";
        if ($result == "You Win") echo "win";
        elseif ($result == "You Lose") echo "lose";
        else echo "tie";
        echo "'>";
        echo "<h2>Result: " . htmlentities($result) . "</h2>";
        echo "<p>Your Play: " . htmlentities($human) . "</p>";
        echo "<p>Computer Play: " . htmlentities($computer) . "</p>";
        echo "</div>";
    }
    
    if (isset($_POST['human']) && $_POST['human'] == 'test') {
        echo "<h2>Testing Tool</h2>\n";
        echo "<pre>\n";
        $choices = ['rock', 'paper', 'scissors'];
        foreach ($choices as $h) {
            foreach ($choices as $c) {
                $result = check($h, $c);
                echo "Human=$h Computer=$c Result=$result\n";
            }
        }
        echo "</pre>\n";
    }
    ?>

    <form method="post">
        <label for="human">Select Your Move:</label>
        <select name="human" id="human">
            <option value="-">Select</option>
            <option value="rock">Rock</option>
            <option value="paper">Paper</option>
            <option value="scissors">Scissors</option>
            <option value="test">Test</option>
        </select>
        <input type="submit" value="Play">
    </form>

    <p><a href="login.html">Logout</a></p>

    <script>
        // Simple client-side storage for game history
        let gameHistory = JSON.parse(localStorage.getItem('rpsHistory')) || [];
        
        function updateHistory(human, computer, result) {
            const game = {
                human: human,
                computer: computer,
                result: result,
                time: new Date().toLocaleString()
            };
            gameHistory.unshift(game);
            if (gameHistory.length > 10) gameHistory = gameHistory.slice(0, 10);
            localStorage.setItem('rpsHistory', JSON.stringify(gameHistory));
            displayHistory();
        }
        
        function displayHistory() {
            const historyBody = document.getElementById('historyBody');
            if (!historyBody) return;
            
            if (gameHistory.length === 0) {
                historyBody.innerHTML = '<tr><td colspan="4" style="text-align: center;">No games played yet.</td></tr>';
                return;
            }
            
            historyBody.innerHTML = gameHistory.map(game => `
                <tr>
                    <td>${game.human}</td>
                    <td>${game.computer}</td>
                    <td>${game.result}</td>
                    <td>${game.time}</td>
                </tr>
            `).join('');
        }
        
        // Initialize history display
        document.addEventListener('DOMContentLoaded', function() {
            // Add history section if it doesn't exist
            if (!document.getElementById('historySection')) {
                const historyHTML = `
                    <h2>Game History</h2>
                    <table border="1">
                        <tr>
                            <th>Your Choice</th>
                            <th>Computer Choice</th>
                            <th>Result</th>
                            <th>Time</th>
                        </tr>
                        <tbody id="historyBody"></tbody>
                    </table>
                `;
                document.body.innerHTML += historyHTML;
                displayHistory();
            }
        });
    </script>
</body>
</html>