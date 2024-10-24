import { Select } from "antd";
import { useSandwiches } from "../../API/features/sandwiches/useSandwiches";
import PropTypes from "prop-types";

const SandwichDropDown = ({onSelect}) => {
  const sandwiches = useSandwiches({});

  if(sandwiches.data == null) return <div>Chargment...</div>;

  const handleChange = (value) => {
    onSelect(value);
  }

  return (
    <Select
      placeholder={"Sélectionner un sandwich"}
      options={sandwiches.data.map(sandwich => ({value: sandwich.id, label: sandwich.label}))} 
      onChange={handleChange}
    />
  );
}

SandwichDropDown.propTypes = {
  onSelect: PropTypes.func
}

export default SandwichDropDown;