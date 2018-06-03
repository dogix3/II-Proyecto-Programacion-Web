var Form = Reactstrap.Form;
var Button = Reactstrap.Button;
var FormGroup = Reactstrap.FormGroup;
var Label = Reactstrap.Label;
var Input = Reactstrap.Input;
var FormText = Reactstrap.FormText;


class RevisionesForm extends React.Component {

    constructor(props) {

       super(props)

    this.state = {id_revision:"",id_programa:0, fecha:"",descripcion:"",id_usuario:0}

    this.handleInsert = this.handleInsert.bind(this);

    this.handleUpdate = this.handleUpdate.bind(this);

    this.handleDelete = this.handleDelete.bind(this);

    this.handleFields = this.handleFields.bind(this);

    this.checkIdFactura = this.checkIdFactura.bind(this);

    }

    componentWillReceiveProps(nextProps) {

       this.setState({id_revision:nextProps.revision.id});

       this.setState({id_programa:nextProps.programa.id});

       this.setState({fecha:nextProps.revision.fecha});

       this.setState({descripcion:nextProps.revision.descripcion});

       this.setState({id_usuario:nextProps.revision.id_usuario});

    }

    handleInsert() {

        fetch("./server/index.php/revision/"+this.state.id_revision,{

            method: "post",

            headers: {'Content-Type': 'application/json',

                               'Content-Length': 20},

            body: JSON.stringify({

                method: 'put',

                id_programa: this.state.id_programa,

                fecha: this.state.fecha,

                descripcion: this.state.descripcion,

                id_usuario: this.state.id_usuario,

                       })

        }).then((response) => {

               this.props.handleChangeData();

             }

        );

    }

    handleUpdate() {

        fetch("./server/index.php/revision/"+this.state.id_revision,{

            method: "post",

            headers: {'Content-Type': 'application/json'},

            body: JSON.stringify({

                id_programa: this.state.id_programa,

                fecha: this.state.fecha,

                descripcion: this.state.descripcion,

                id_usuario: this.state.id_usuario,

                       })

        }).then((response) => {

           this.props.handleChangeData();

         }

        );

    }

    handleDelete() {

        fetch("./server/index.php/revision/"+this.state.id_revision,{

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

     let value = target.value;

     const name = target.name;
    
     this.setState({[name]: value});

  }
 checkIdFactura(){
    if (this.props.programa.id==='undefined') {      
      return ''
    }else{
      //this.setState({id_programa: this.props.programa.id_programa});
      //this.state.id_programa = this.props.programa.id_programa;
      return this.props.programa.id
    }
  }
    render() {

        return(<Form><table><tbody>

           <tr><td width="30%"><Label>Id revision:</Label></td>

               <td width="20%"><Input disabled="true" type="text" name="id"

                   value={this.state.id_revision} onChange={this.handleFields}/></td></tr>

           <tr><td><Label>Id programa:</Label></td>

               <td><Input type="text" name="id_programa"

                   value={this.state.id_programa} onChange={this.handleFields}/></td></tr>

           <tr><td><Label>Descripción:</Label></td>

               <td><Input type="text" name="descripcion"

                   value={this.state.descripcion} onChange={this.handleFields}/></td></tr>

           <tr><td><Label>Fecha:</Label></td>

               <td><Input type="date" name="fecha"

                   value={this.state.fecha} onChange={this.handleFields}/></td></tr>

           <tr><td><Label>Id usuario:</Label></td>

               <td><Input type="number" name="id_usuario"

                   value={this.state.id_usuario} onChange={this.handleFields}/></td></tr>

           </tbody></table><Input type="hidden" name="id_revision" value={this.state.id_revision}/>

           <table><tbody><tr>

               <td><Button onClick={this.handleInsert}>Agregar</Button></td>

               <td><Button onClick={this.handleUpdate}>Modificar</Button></td>

               <td><Button onClick={this.handleDelete}>Eliminar</Button></td>

           </tr></tbody></table></Form>)

    }

}