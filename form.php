<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
        integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<form id="contactForm">
    <div>
        <input type="email" name="email" id="email" placeholder="Your Email" required>
    </div>
    <button type="submit">Send Code</button>
</form>

<!-- Code Verification Form -->
<form id="codeForm" style="display:none;">
    <div>
        <input type="text" name="code" id="code" placeholder="Enter Code" required>
    </div>
    <button type="submit">Verify</button>
</form>

<div class="loading-area" style="display:none;">Sending Code...</div>
<div id="result" style="display:none;"></div>

<style>
    /* General Styling */
    form {
        width: 100%;
        max-width: 400px;
        margin: 20px auto;
        padding: 20px;
        border: 1px solid #ccc;
        border-radius: 8px;
        background-color: #f9f9f9;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        text-align: center;
    }
    
    input, button {
        width: 100%;
        padding: 10px;
        margin: 10px 0;
        border-radius: 4px;
        font-size: 16px;
        box-sizing: border-box;
    }

    button {
        background-color: #007bff;
        color: white;
        border: none;
        cursor: pointer;
    }

    button:hover {
        background-color: #0056b3;
    }

    .loading-area {
        text-align: center;
        margin-top: 10px;
        color: #007bff;
        font-weight: bold;
    }

    #result {
        text-align: center;
        font-size: 18px;
        margin-top: 20px;
        font-weight: bold;
    }
</style>

<script>
$(document).ready(function() {
    let sentCode = "";

    $("#contactForm").submit(function(e) {
        e.preventDefault();
        $('.loading-area').show();
        $('#contactForm').hide();
        
        var email = $("#email").val();
        
        $.ajax({
            type: "POST",
            url: "sendEmail.php",
            data: { email: email },
            success: function(response) {
                $('.loading-area').hide();
                $('#codeForm').show();
                sentCode = response.trim();
            },
            error: function() {
                alert("Error sending email.");
            }
        });
    });

    $("#codeForm").submit(function(e) {
        e.preventDefault();
        
        var enteredCode = $("#code").val();
        
        if (enteredCode === sentCode) {
            $("#result").text("Hi, Welcome!").css("color", "green").fadeIn();
        } else {
            $("#result").text("Get Lost!").css("color", "red").fadeIn();
        }
    });
});
</script>
