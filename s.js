let claiming = false; // Flag to control claiming process

async function getBalance(jwt) {
    const response = await fetch('https://game-domain.blum.codes/api/v1/user/balance', {
        method: 'GET',
        headers: {
            'Authorization': `Bearer ${jwt}`
        }
    });
    if (!response.ok) {
        throw new Error('Failed to fetch balance: ' + response.statusText);
    }
    return await response.json();
}

async function playGame(jwt) {
    const response = await fetch('https://game-domain.blum.codes/api/v1/game/play', {
        method: 'POST',
        headers: {
            'Authorization': `Bearer ${jwt}`
        }
    });
    if (!response.ok) {
        throw new Error('Failed to start game: ' + response.statusText);
    }
    return await response.json();
}

async function claimPoints(jwt, gameId, points) {
    const response = await fetch('https://game-domain.blum.codes/api/v1/game/claim', {
        method: 'POST',
        headers: {
            'Authorization': `Bearer ${jwt}`,
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ gameId, points })
    });
    return response.ok;
}

async function easyFarm(jwt, pointsRange) {
    const [minPoints, maxPoints] = pointsRange.split('-').map(Number);

    // Validate points range
    if (isNaN(minPoints) || isNaN(maxPoints) || minPoints >= maxPoints) {
        document.getElementById('output').innerText += `Invalid points range: ${pointsRange}\n`;
        return;
    }

    let gamePasses = 1; // Assume at least one game pass for demonstration

    while (claiming && gamePasses > 0) {
        const balance = await getBalance(jwt);
        const availableBalance = parseFloat(balance.availableBalance);
        gamePasses = balance.playPasses;

        document.getElementById('output').innerText += `BP's: ${availableBalance.toFixed(2)}\nGP's left: ${gamePasses}\n`;

        const game = await playGame(jwt);
        const gameId = game.gameId;

        document.getElementById('output').innerText += `Game started! Game ID: ${gameId}\nWaiting for 30 secs...\n`;
        await new Promise(resolve => setTimeout(resolve, 30000)); // Wait for 30 seconds

        // Generate a random claim amount
        const bpClaimAmount = Math.floor(Math.random() * (maxPoints - minPoints + 1)) + minPoints;

        // Log the claim amount for debugging
        console.log(`Claim Amount: ${bpClaimAmount}`);

        const claimSuccess = await claimPoints(jwt, gameId, bpClaimAmount);

        if (claimSuccess) {
            document.getElementById('output').innerText += `BP's claimed! BP's claim: ${bpClaimAmount}\n`;
        } else {
            document.getElementById('output').innerText += `Failed to claim BP's.\n`;
        }

        document.getElementById('output').innerText += `Sleep for 10 secs...\n`;
        await new Promise(resolve => setTimeout(resolve, 10000)); // Sleep for 10 seconds

        // Check if claiming has been stopped
        if (!claiming) {
            document.getElementById('output').innerText += `Claiming process has been stopped.\n`;
            break; // Exit the loop if claiming is false
        }
    }
}

document.getElementById('startClaim').addEventListener('click', async () => {
    const jwt = document.getElementById('jwt').value;
    const pointsRange = document.getElementById('pointsRange').value;
    document.getElementById('output').innerText = ''; // Clear previous output
    claiming = true; // Set claiming to true
    document.getElementById('stopClaim').style.display = 'inline'; // Show stop button

    // Show notification message
    showNotification('Claiming started!');

    try {
        await easyFarm(jwt, pointsRange);
    } catch (error) {
        document.getElementById('output').innerText += `Error: ${error.message}\n`;
    }
});

document.getElementById('stopClaim').addEventListener('click', () => {
    claiming = false; // Set claiming to false
    document.getElementById('stopClaim').style.display = 'none'; // Hide stop button
    showNotification('Claiming stopped. Redirecting...'); // Show notification

    // Redirect to Telegram bot after 3 seconds
    setTimeout(() => {
        window.location.href = 'https://telegram.me/CryptoGuideAkram';
    }, 3000);
});

// Function to show notification
function showNotification(message) {
    const notification = document.getElementById('notification');
    const notificationMessage = document.getElementById('notificationMessage');
    notificationMessage.innerText = message;
    notification.style.display = 'block';

    // Hide notification after 3 seconds
    setTimeout(() => {
        notification.style.display = 'none';
    }, 3000);
}