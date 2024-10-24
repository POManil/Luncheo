import { Menu } from 'antd';
import { Link, useLocation } from 'react-router-dom';

const Header = () => {
  const location = useLocation();

  const items = [
    { label: 'Commandes', to: '/orders' },
    { label: 'Introduction', to: '/intro' },
  ];

  const renderNavBar = () => items.map(item => 
    <Menu.Item key={item.to}>
      <Link to={item.to}>{item.label}</Link>
    </Menu.Item>
  )

  return (      
    <Menu
      theme="dark"
      mode="horizontal"
      selectedKeys={[location.pathname]} 
      style={{ position: 'absolute', top: '0', right: '0', width: '100%' }}
    >
      {renderNavBar()}
    </Menu>
  );
};

export default Header;
