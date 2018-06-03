var Form = Reactstrap.Form;
var Button = Reactstrap.Button;
var FormGroup = Reactstrap.FormGroup;
var Label = Reactstrap.Label;
var Input = Reactstrap.Input;
var FormText = Reactstrap.FormText;


class RevisionesForm extends React.Component {

    constructor(props) {

       super(props)

    this.state = {id_producto:"",id_factura:0,cantidad:0,descripcion:"",valUnit:0.0,subTotal:0.0}

    this.handleInsert = this.handleInsert.bind(this);

    this.handleUpdate = this.handleUpdate.bind(this);

    this.handleDelete = this.handleDelete.bind(this);

    this.handleFields = this.handleFields.bind(this);

    }

    componentWillReceiveProps(nextProps) {

       this.setState({id_producto:nextProps.producto.id});

       this.setState({id_factura:nextProps.producto.id_factura});

       this.setState({cantidad:nextProps.producto.cantidad});

       this.setState({descripcion:nextProps.producto.descripcion});

       this.setState({valUnit:nextProps.producto.valUnit});

       this.setState({subTotal:nextProps.producto.subTotal});

    }

    handleInsert() {

        fetch("./server/index.php/producto/"+this.state.id_producto,{

            method: "post",

            headers: {'Content-Type': 'application/json',

                               'Content-Length': 20},

            body: JSON.stringify({

                method: 'put',

                id_factura: this.state.id_factura,

                cantidad: this.state.cantidad,

                descripcion: this.state.descripcion,

                valUnit: this.state.valUnit,

                subTotal: this.state.subTotal

                       })

        }).then((response) => {

               this.props.handleChangeData();

             }

        );

        fetch("./server/index.php/factura/"+this.state.id_factura,{

            method: "post",

            headers: {'Content-Type': 'application/json'},

            body: JSON.stringify({ method: 'updateTotal'})

         }).then((response) => {

               this.props.handleChangeData();

             }

        );

    }

    handleUpdate() {

        fetch("./server/index.php/producto/"+this.state.id_producto,{

            method: "post",

            headers: {'Content-Type': 'application/json'},

            body: JSON.stringify({

                id_factura: this.state.id_factura,

                cantidad: this.state.cantidad,

                descripcion: this.state.descripcion,

                valUnit: this.state.valUnit,

                subTotal: this.state.subTotal

                       })

        }).then((response) => {

           this.props.handleChangeData();

         }

        );

        fetch("./server/index.php/factura/"+this.state.id_factura,{

            method: "post",

            headers: {'Content-Type': 'application/json'},

            body: JSON.stringify({ method: 'updateTotal'})

         }).then((response) => {

               this.props.handleChangeData();

             }

        );

    }

    handleDelete() {

        fetch("./server/index.php/producto/"+this.state.id_producto,{

            method: "post",

            headers: {'Content-Type': 'application/json'},

            body: JSON.stringify({ method: 'delete'})

        }).then((response) => {

           this.props.handleChangeData();

         }

        );

        fetch("./server/index.php/factura/"+this.state.id_factura,{

            method: "post",

            headers: {'Content-Type': 'application/json'},

            body: JSON.stringify({ method: 'updateTotal'})

         }).then((response) => {

               this.props.handleChangeData();

             }

        );

    }

    handleFields(event) {

     const target = event.target;

     let value = target.value;

     const name = target.name;
     (target.type==='number') ? 
      (
        (name==='cantidad') ? this.state.subTotal=value*this.state.valUnit : this.state.subTotal=value*this.state.cantidad
      )
     : '';
    
     this.setState({[name]: value});

  }

    render() {

        return(<Form><table><tbody>

           <tr><td width="30%"><Label>Id:</Label></td>

               <td width="20%"><Input disabled="true" type="text" name="id_producto"

                   value={this.state.id_producto} onChange={this.handleFields}/></td></tr>

           <tr><td><Label>Id_factura:</Label></td>

               <td><Input type="text" name="id_factura"

                   value={this.state.id_factura} onChange={this.handleFields}/></td></tr>

           <tr><td><Label>Cantidad:</Label></td>

               <td><Input type="number" name="cantidad"

                   value={this.state.cantidad} onChange={this.handleFields}/></td></tr>

           <tr><td><Label>Descripcion:</Label></td>

               <td><Input type="text" name="descripcion"

                   value={this.state.descripcion} onChange={this.handleFields}/></td></tr>

           <tr><td><Label>ValUnit:</Label></td>

               <td><Input type="number" name="valUnit"

                   value={this.state.valUnit} onChange={this.handleFields}/></td></tr>

           <tr><td><Label>SubTotal:</Label></td>

               <td><Input type="number" name="subTotal"

                   value={this.state.subTotal} onChange={this.handleFields}/></td></tr>

           </tbody></table><Input type="hidden" name="id_producto" value={this.state.id_producto}/>

           <table><tbody><tr>

               <td><Button onClick={this.handleInsert}>Agregar</Button></td>

               <td><Button onClick={this.handleUpdate}>Modificar</Button></td>

               <td><Button onClick={this.handleDelete}>Eliminar</Button></td>

           </tr></tbody></table></Form>)

    }

}