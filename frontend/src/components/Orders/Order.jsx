import { Button, Card, InputNumber } from "antd";
import PropTypes from "prop-types";

import * as Formatter from "../../helpers/formatter";
import UserDropDown from "../Users/UserDropDown";
import { useState } from "react";
import SandwichDropDown from "../Sandwiches/SandwichesDropDown";
import { useUpsertOrderLines } from "../../API/features/orders/useUpsertOrderLines";
import { useUsers } from "../../API/features/users/useUsers";
import { useSandwiches } from "../../API/features/sandwiches/useSandwiches";

const Order = ({order}) => {
  const [isEditMode, setIsEditMode] = useState(false);
  const [newOrderLine, setNewOrderLine] = useState({
    orderId: order.id, 
    sandwichId: null, 
    userId: null, 
    quantity: 0
  });

  const upsertOrderLineHandler = useUpsertOrderLines();
  const users = useUsers({});
  const sandwiches = useSandwiches({});

  if(users.data == null || sandwiches.data == null) return <div>Chargement...</div>;

  const handleOrderLineChange = (key) => (value) => {
    console.log("key", key, "val", value);

    setNewOrderLine(previous => ({
      ...previous,
      [key] : value
    }));
  }

  const toggleEditMode = (e) => {
    e.preventDefault();
    setIsEditMode(!isEditMode);
  }

  const saveOrderLine = async () => {
    try {
      await upsertOrderLineHandler.mutateAsync({orderLine: newOrderLine});
    } catch (error) {
      console.log(error);
    }
  }

  const deleteOrderLine = async (line) => {
    console.log(line);
  }

  const orderTotalPrice = () => order.lines.reduce((result, line) => result + line.price, .0);

  return (
    <Card 
      title={`Commande du ${Formatter.toDateString(order.orderDate.date)} (${orderTotalPrice()}€)`}
      styles={{
        header: {backgroundColor: 'goldenrod'},
        body: {backgroundColor: 'beige'}
      }}
    >
      {
        order.lines.map((line, index) => 
          <Card 
            hoverable
            title={users.data.find(u => u.id == line.userId).firstname}
            type="inner"  
            key={'orderline' + index}
            styles={{
              header: {backgroundColor: 'lightskyblue'},
              body: {backgroundColor: 'lightblue'},
            }}
          >
            Sandwich &laquo; {sandwiches.data.find(s => s.id == line.sandwichId).label} &raquo;
            <br/>
            Quantité: {line.quantity}
            <br/>
            Total : {line.price} €
            {
              isEditMode && (
                <>
                  <br/>
                  <Button onClick={() => deleteOrderLine(line)}>
                    Supprimer
                  </Button>
                </>
              )
            }
          </Card>
        )
      }
      {
        isEditMode && (
          <div style={{display: 'flex', flexDirection: 'column', marginTop: '10px'}}>
            <UserDropDown onSelect={handleOrderLineChange("userId")}/>
            <SandwichDropDown onSelect={handleOrderLineChange("sandwichId")}/>
            <InputNumber min={1} max={1000} defaultValue={1} onChange={handleOrderLineChange("quantity")}/>

            <Button onClick={saveOrderLine} style={{marginTop: "10px"}}>
              Enregistrer
            </Button>
          </div>
        )
      }

      <Button onClick={toggleEditMode} style={{marginTop: "10px"}}>
      { isEditMode ? "Annuler" : "Editer" }  
      </Button>
    </Card>
  )
}

export const OrderLinePropType = PropTypes.shape({
  orderId: PropTypes.number,
  userId: PropTypes.number, 
  sandwichId: PropTypes.number,
  price: PropTypes.number,
  quantity: PropTypes.number,
});

export const OrderProptype = PropTypes.shape({
  id: PropTypes.number, 
  orderDate: PropTypes.oneOfType([PropTypes.string, PropTypes.object]), 
  isPaid: PropTypes.bool,
  lines: PropTypes.arrayOf(OrderLinePropType),
});

Order.propTypes = {
  order: OrderProptype
};

export default Order;