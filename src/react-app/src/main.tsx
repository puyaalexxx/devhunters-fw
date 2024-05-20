import React from "react";
import ReactDOM from "react-dom/client";
import App from "./App.tsx";
import "./index.css";

//get the app selector from WordPress dynamically
// @ts-ignore
const dhtOptionsAppArea = window.dht_options_selector || {};
const { optionsAppSelector } = dhtOptionsAppArea;

//options app area to load
if (optionsAppSelector) {
    ReactDOM.createRoot(document.getElementById(optionsAppSelector)!).render(
        <React.StrictMode>
            <App />
        </React.StrictMode>
    );
} else {
    ReactDOM.createRoot(document.getElementById("root")!).render(
        <React.StrictMode>
            <App />
        </React.StrictMode>
    );
}
