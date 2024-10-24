import { Button, Card, InputNumber } from "antd";
import PropTypes from "prop-types";

import * as Formatter from "../../helpers/formatter";
import UserDropDown from "../Users/UserDropDown";
import { useState } from "react";
import SandwichDropDown from "../Sandwiches/SandwichesDropDown";
import { useUpsertOrderLines } from "../../API/features/orders/useUpsertOrderLines";

const Order = ({order}) => {
  const [isEditMode, setIsEditMode] = useState(false);
  const [newOrderLine, setNewOrderLine] = useState({
    orderId: order.id, 
    sandwichId: null, 
    userId: null, 
    quantity: 0
  });

  const upsertOrderLineHandler = useUpsertOrderLines();

  const handleOrderLineChange = (key) => (value) => {
    setNewOrderLine(previous => ({
      ...previous,
      [key] : value
    }));
  }

  const toggleEditMode = (e) => {
    e.preventDefault();
    setIsEditMode(!isEditMode);
  }

  const saveOrder = async () => {
    try {
      console.log("nol", newOrderLine)
      await upsertOrderLineHandler.mutateAsync({newOrderLine});
    } catch (error) {
      console.log(error);
    }
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
        order.lines.map(line => 
          <Card 
            hoverable
            title={'user ' + line.userId}
            type="inner"  
            key={line.userId + line.sandwichId}
            styles={{
              header: {backgroundColor: 'lightskyblue'},
              body: {backgroundColor: 'lightblue'},
            }}
          >
            Sandwich id: {line.sandwichId} quantity: {line.quantity}
            <br/>
            Total : {line.price} €
          </Card>
        )
      }
      {
        isEditMode && (
          <div style={{display: 'flex', flexDirection: 'column', marginTop: '10px'}}>
            <UserDropDown onSelect={() => handleOrderLineChange("userId")}/>
            <SandwichDropDown onSelect={() => handleOrderLineChange("sandwichId")}/>
            <InputNumber min={1} max={1000} defaultValue={1} onChange={() => handleOrderLineChange("quantity")}/>

            <Button onClick={saveOrder} style={{marginTop: "10px"}}>
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