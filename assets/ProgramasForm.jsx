var Form = Reactstrap.Form;
var Button = Reactstrap.Button;
var FormGroup = Reactstrap.FormGroup;
var Label = Reactstrap.Label;
var Input = Reactstrap.Input;
var FormText = Reactstrap.FormText;

 class ProgramasForm extends React.Component {

    constructor(props) {

       super(props)

    this.state = {id:"",cliente:"",fecha:"",impuestos:13.0,montoTotal:0.0}

    this.handleInsert = this.handleInsert.bind(this);

    this.handleUpdate = this.handleUpdate.bind(this);

    this.handleDelete = this.handleDelete.bind(this);

    this.handleFields = this.handleFields.bind(this);

    }

    componentWillReceiveProps(nextProps) {

       this.setState({id:nextProps.factura.id});

       this.setState({cliente:nextProps.factura.cliente});

       this.setState({name:nextProps.factura.name});

       this.setState({fecha:nextProps.factura.fecha});

       this.setState({impuestos:nextProps.factura.impuestos});

       this.setState({montoTotal:nextProps.factura.montoTotal});

    }

    handleInsert() {

        fetch("./server/index.php/factura/"+this.state.id,{

            method: "post",

            headers: {'Content-Type': 'application/json',

                               'Content-Length': 20},

            body: JSON.stringify({

                method: 'put',

                cliente: this.state.cliente,

                fecha: this.state.fecha,

                impuestos: this.state.impuestos,

                montoTotal: this.state.montoTotal

                       })

    }).then((response) => {

           this.props.handleChangeData();

         }

    );

    }

    handleUpdate() {

        fetch("./server/index.php/factura/"+this.state.id,{

            method: "post",

            headers: {'Content-Type': 'application/json'},

            body: JSON.stringify({

                      cliente: this.state.cliente,

                fecha: this.state.fecha,

                impuestos: this.state.impuestos,

                montoTotal: this.state.montoTotal

                       })

     }).then((response) => {

           this.props.handleChangeData();

         }

    );

    }

    handleDelete() {

      fetch("./server/index.php/producto/"+this.state.id,{

            method: "post",

            headers: {'Content-Type': 'application/json'},

            body: JSON.stringify({ method: 'deleteAll'})

        }).then((response) => {

           this.props.handleChangeData();

         }

      );

        fetch("./server/index.php/factura/"+this.state.id,{

            method: "post",

            headers: {'Content-Type': 'application/json'},

            body: JSON.stringify({ method: 'delete'})

        }).then((response) => {

           this.props.handleChangeData();

         }

    );

    }

    handleFields(event) {

     const target = event.target;

     const value = target.value;

     const name = target.name;

     this.setState({[name]: value});

  }

    render() {

        return(<Form><Table><tbody>

           <tr><td width="30%"><Label>Nombre:</Label></td>

               <td width="20%"><Input type="text" name="cliente"

                   value={this.state.cliente} onChange={this.handleFields}/></td></tr>

           <tr><td><Label>Numero de versión:</Label></td>

               <td><Input type="text" name="fecha"

                   value={this.state.fecha} onChange={this.handleFields}/></td></tr>

            <tr><td><Label>Fecha publicación:</Label></td>

                <td><Input type="text" name="fecha"

                    value={this.state.fecha} onChange={this.handleFields}/></td></tr>

           <tr><td><Label>Lenguajes:</Label></td>

               <td><Input type="text" name="impuestos"

                   value={this.state.impuestos} onChange={this.handleFields}/></td></tr>

           <tr><td><Label>Descripción:</Label></td>

               <td><Input type="text" name="montoTotal"

                   value={this.state.montoTotal} onChange={this.handleFields}/></td></tr>

            <tr><td><Label>Programador:</Label></td>

                <td><Input type="text" name="montoTotal"

                    value={this.state.montoTotal} onChange={this.handleFields}/></td></tr>

           </tbody></Table><Input type="hidden" name="id" value={this.state.id}/>

           <Table><tbody><tr>

               <td><Button onClick={this.handleInsert}>Agregar</Button></td>

               <td><Button onClick={this.handleUpdate}>Modificar</Button></td>

               <td><Button onClick={this.handleDelete}>Eliminar</Button></td>

           </tr></tbody></Table></Form>)

    }

}