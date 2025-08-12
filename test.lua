wrk.method = "POST"
wrk.headers["Content-Type"] = "application/json"
wrk.body = '{"username": "testuser", "password": "testpass"}'

-- wrk -t4 -c100 -d30s -s post.lua http://localhost:8080/api/endpoint
