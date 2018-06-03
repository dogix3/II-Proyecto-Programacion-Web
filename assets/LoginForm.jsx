var Form = Reactstrap.Form;
var Button = Reactstrap.Button;
var FormGroup = Reactstrap.FormGroup;
var Label = Reactstrap.Label;
var Input = Reactstrap.Input;
var Row = Reactstrap.Row;
var Col = Reactstrap.Col;

class LoginForm extends React.Component {

    constructor(props) {

        super(props)

        this.state = { id: "", is_login: "", usuario: "", password: "", nombre: "", tipo_usuario: "" }

        this.handleFields = this.handleFields.bind(this);

        this.login = this.login.bind(this);
        this.handleRegister = this.handleRegister.bind(this);

    }
    handleFields(event) {

        const target = event.target;

        let value = target.value;

        const name = target.name;

        this.setState({ [name]: value });

    }
    login() {
        this.props.checkLogin(this.state.usuario, this.state.password);
    }
    handleRegister() {
        this.props.handleEditData();
    }
    render() {

        return (<Form>
            <Container>
                <Row>
                    <div className="text-center divLoginContent">
                        <Col xs="4" className="frmLoginContent">
                            <Row>
                                <Col xs="12">
                                    <Label>Usuario</Label>
                                </Col>
                                <Col xs="12">
                                    <Input type="text" name="usuario"
                                        value={this.state.usuario} onChange={this.handleFields} />
                                </Col>
                            </Row>
                            <Row>
                                <Col xs="12">
                                    <Label>Contraseña</Label>
                                </Col>
                                <Col xs="12">
                                    <Input type="password" name="password"
                                        value={this.state.password} onChange={this.handleFields} />
                                </Col>
                            </Row>
                            <Row>
                                <Col xs="12">
                                    <Button className="btn_login" onClick={this.login}>Ingresar</Button>
                                </Col>
                                <Col xs="12">
                                    <Button className="btn_register" onClick={this.handleRegister}>Registrarse</Button>
                                </Col>
                            </Row>
                        </Col>
                    </div>
                </Row>
            </Container>
        </Form>)

    }

}