import React, { useState } from "react";
import axios from "axios";

function Verification() {
  const [Code, setCode] = useState("");

  const handleVerification = async (e) => {
    e.preventDefault();
    try {
      const response = await axios.post("/verify", { Code: Code });
      if (response.data.message === "Incorrect code") {
        alert("Verification code is incorrect. Please try again."); // Show a success message
      } else {
        alert(" Verification code Succesfully"); // Show an error message
      }
    } catch (error) {
      console.error('Error verifying code:', error.message);
      alert("Something went wrong. Please try again later.");
    }
  };

    return (
        <div className='VerificationForm'>
            <h2>Verification</h2>
            <form onSubmit={handleVerification}>
                <label>
                    Enter Verification Code:
                    <input
                        type="number"
                        value={Code}
                        onChange={(e) => setCode(e.target.value)}
                        required
                    />
                </label>
                <button type="submit">Verify</button>
            </form>
        </div>
    );
}

export default Verification;
