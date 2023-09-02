//export default Cart;

class Cart {
    constructor() {
      this.items = [];
    }
  
    addItem(product, quantity) {
      this.items.push({ product, quantity });
    }
  
    removeItem(product) {
      this.items = this.items.filter(item => item.product !== product);
    }
  
    getTotal() {
      return this.items.reduce((total, item) => total + item.product.price * item.quantity, 0);
    }
  
    getItems() {
      return this.items;
    }
  
    clearCart() {
      this.items = [];
    }
  }
  

  // Ejemplo de uso
  const cart = new Cart();
  
  const product1 = { name: 'Product 1', price: 10 };
  const product2 = { name: 'Product 2', price: 20 };
  
  cart.addItem(product1, 2);
  cart.addItem(product2, 1);
  
  console.log('Items in cart:', cart.getItems());
  console.log('Total:', cart.getTotal());
  
  cart.removeItem(product1);
  
  console.log('Items in cart after removal:', cart.getItems());
  
  cart.clearCart();
  
  console.log('Items in cart after clearing:', cart.getItems());
  