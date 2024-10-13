<?php
    // Get json stream content
    $json = file_get_contents('php://input');
    
    if(!empty($json)) {
        // Decode json string
        $obj = json_decode($json);

        // If json is valid
        if(json_last_error() === JSON_ERROR_NONE) {
            $passwordsalt = 'S47TnP3pp3R';

            // if api key is valid
            if(password_verify($passwordsalt,$obj->apikey)) {
                //$fp = file_put_contents('remote-temperature.log', $json);

                // Connect to database
                $servername = "localhost";
                $username = "solartherm";
                $password = "solartherm";
                $dbname = "solartherm";

                // Create connection
                $conn = new mysqli($servername, $username, $password, $dbname);

                // Check connection
                if ($conn->connect_error) {
                    die("Database Connection failed: " . $conn->connect_error);
                }

                // Get current date and time
                date_default_timezone_set('Europe/Berlin');
                $d = date("Y-m-d");
                $t = date("H:i:s");

                $last_id = '';
                $status_msg = '';
                $status_msg2 = '';
                $status_msg3 = '';

                // If basic json objects are not empty
                if(!empty($obj->name) || !empty($obj->temperature) || !empty($obj->humidity) || !empty($obj->battery)) {
                    $solarName = $obj->name;
                    $sensorData1 = $obj->temperature;
                    $sensorData2 = $obj->humidity;
                    $sensorData3 = $obj->pressure;
                    $sensorData4 = $obj->altitude;
                    $sensorData5 = $obj->battery;

                    // Create new db table record
                    $sql = "INSERT INTO sensors (name, temperature, humidity, pressure, altitude, battery, Date, Time) VALUES ('".$solarName."','".$sensorData1."', '".$sensorData2."', '".$sensorData3."', '".$sensorData4."', '".$sensorData5."', '".$d."', '".$t."')";

                    if ($conn->query($sql) === TRUE) {
                        $last_id = $conn->insert_id;
                        $status_msg = "OK";
                    } else {
                        $status_msg = "Error: " . $sql . "<br>" . $conn->error;
                    }

                    if(!empty($last_id) && (!empty($obj->temperature_out) || !empty($obj->uv_index) || !empty($obj->lux) || !empty($obj->temperature_esp_core))) {
                        $sensorData6 = $obj->temperature_out;
                        $sensorData7 = $obj->rainfall_hourly;
                        $sensorData8 = $obj->rainfall_last24;
                        $sensorData9 = $obj->temperature_esp_core;
                        $sensorData10 = $obj->wind_speed;
                        $sensorData11 = $obj->wind_direction;
                        $sensorData12 = $obj->uv_index;
                        $sensorData13 = $obj->lux;
                        $sensorData14 = $obj->boot_count;

                        // Create new db table record
                        $sql2 = "INSERT INTO outdoor_sensors (sensors_id, temperature_out, rainfall_hourly, rainfall_last24, temperature_esp_core, wind_speed, wind_direction, uv_index, lux, boot_count) VALUES ('".$last_id."','".$sensorData6."','".$sensorData7."', '".$sensorData8."', '".$sensorData9."', '".$sensorData10."', '".$sensorData11."', '".$sensorData12."', '".$sensorData13."', '".$sensorData14."')";

                        if ($conn->query($sql2) === TRUE) {
                            $status_msg2 = "OK";
                        } else {
                            $status_msg2 = "Error: " . $sql2 . "<br>" . $conn->error;
                        }
                    }

                    if(!empty($last_id) && !empty($obj->boot_log)) {
                        $boot_log = $obj->boot_log;

                        // Create new db table record
                        $sql3 = "INSERT INTO boot_log (sensors_id, boot_log) VALUES ('".$last_id."', '".$boot_log."')";

                        if ($conn->query($sql3) === TRUE) {
                            $status_msg3 = "OK";
                        } else {
                            $status_msg3 = "Error: " . $sql3 . "<br>" . $conn->error;
                        }
                    }
                }

                if (!empty($status_msg) || !empty($status_msg2) || !empty($status_msg3)) {
                    echo $status_msg;
                    echo $status_msg2;
                    echo $status_msg3;
                }

                // Close connection
                $conn->close();
            }
        }
    }
?>