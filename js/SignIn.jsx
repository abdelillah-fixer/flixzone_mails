import React, { useState, useContext } from "react";
import "../components/styles/Sign.css";
import axios from "axios";
import { Link, useNavigate } from "react-router-dom";


function SignIn() {
  const [email, setEmail] = useState("");
  const [password, setPassword] = useState("");

  const navigate = useNavigate()
  const handleSignIn = async (e) => {
    e.preventDefault();
    // Add your sign-in logic here, e.g., make an API call to authenticate the user
    try {
        const response = await axios.post("/login", { email, password });
        if (response.data.message === "Success") {
          window.location.href = "/verification"; // Redirect to the verification page
        }
      } catch (error) {
        alert("Something wrong happened. Please try again later.");
        console.error('Error signing in:', error.message);
      }
    };

  return (
    <div className="LoginForm">
      <h2>Se connecter</h2>
      <form onSubmit={handleSignIn}>
        <label>
          <input
            placeholder="Email"
            type="email"
            value={email}
            onChange={(e) => setEmail(e.target.value)}
            required
          />
        </label>
        <br />
        <label>
          <input
            placeholder="Mot de pass"
            type="password"
            value={password}
            onChange={(e) => setPassword(e.target.value)}
            required
          />
        </label>
        <br />
        <button type="submit">Sign In</button>
      </form>
      <p>
        Vous n'avez pas de compte ?{" "}
        <Link className="SignupLabel" to={"/signup"}>
          S'inscrire maintenant
        </Link>
      </p>
    </div>
  );
}

export default SignIn;