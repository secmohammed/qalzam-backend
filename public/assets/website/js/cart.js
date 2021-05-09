/**
 * set Product Id To Cart
 * @param productId
 */
function addToCart(product, price, quantity = 1)
{
    let cart = this.getCart();
    if( cart === null){
        cart = [];
    }
    // new product to cart
    let newProduct = {
        product_variation_id:product.id,
        product_price:price,
        product_total:price * quantity,
        quantity:quantity
    };
    cart.findIndex(x => x.product_variation_id == newProduct.product_variation_id) == -1 ? cart.push(newProduct) : alert('This Product already in Cart');
    localStorage.setItem('cart', JSON.stringify(cart));
}

/**
 * get All Cart Data
 */
function getCart()
{
    return JSON.parse(localStorage.getItem('cart'));
}

/**
 *
 */
function clearCart()
{
    localStorage.removeItem('cart');
}

function countProductsInCart()
{
    let cart = this.getCart();
    return cart.length;
}
