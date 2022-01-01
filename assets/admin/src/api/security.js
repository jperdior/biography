import axios from "axios";

export default {
  login(email, password) {
    return axios.post("/api/security/login", {
      username: email,
      password: password
    });
  }
}