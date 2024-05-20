import "./OptionsWrapper.pcss";
import SubmitButton from "./SubmitButton/SubmitButton.tsx";
import Divider from "./Divider/Divider.tsx";
import FieldWrapper from "./FieldWrapper/FieldWrapper.tsx";

// Define a functional component
const OptionsWrapper = () => {
    return (
        <div className="dht-wrapper">
            <div className="dht-container">
                <form action="" method="post" encType="multipart/form-data">
                    <SubmitButton />

                    <Divider />

                    <div className="dht-form-wrapper">
                        <FieldWrapper />
                    </div>

                    <Divider />

                    <SubmitButton />
                </form>
            </div>
        </div>
    );
};

// Export the component so it can be used elsewhere
export default OptionsWrapper;
