import { Select } from "antd";
import { useUsers } from "../../API/features/users/useUsers";
import PropTypes from "prop-types";

const UserDropDown = ({onSelect}) => {
  const users = useUsers({});

  console.log("users->", users.data)

  if(users.data == null) return <div>Chargment...</div>;

  const handleChange = (value) => {
    console.log("value->", value)
    onSelect(value);
  }

  return (
    <Select
      placeholder={"Ajouter pour une personne ?"}
      options={users.data.map(user => ({value: user.id, label: user.email}))} 
      onChange={handleChange}
    />
  );
}

UserDropDown.propTypes = {
  onSelect: PropTypes.func
}

export default UserDropDown;