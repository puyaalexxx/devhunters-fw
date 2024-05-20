import "./FieldWrapper.pcss";
import React from "react";
import Divider from "../Divider/Divider.tsx";
import Tooltip from "../Tooltip/Tooltip.tsx";

// Define a functional component
const FieldWrapper = () => {
    return (
        <React.Fragment>
            <div className="dht-field-wrapper">
                <div className="dht-title">Field Title</div>
                Option type here
                <Tooltip />
            </div>

            <Divider />
        </React.Fragment>
    );
};

// Export the component so it can be used elsewhere
export default FieldWrapper;
