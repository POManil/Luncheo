import { Select } from "antd";
import { useUsers } from "../../API/features/users/useUsers";
import PropTypes from "prop-types";

const UserDropDown = ({onSelect}) => {
  const users = useUsers({});

  if(users.data == null) return <div>Chargment...</div>;

  const handleChange = (value) => {
    onSelect(value);
  }

  return (
    <Select
      placeholder={"Sélectionner une personne"}
      options={users.data.map(user => ({value: user.id, label: user.email}))} 
      onChange={handleChange}
    />
  );
}

UserDropDown.propTypes = {
  onSelect: PropTypes.func
}

export default UserDropDown;